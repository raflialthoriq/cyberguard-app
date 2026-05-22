<?php
namespace App\Controllers;
use App\Models\PenggunaModel;

class Profil extends BaseController
{
    public function index()
    {
        if (!session()->get('peran')) return redirect()->to('/auth');

        $penggunaModel = new \App\Models\PenggunaModel();
        $db = \Config\Database::connect();
        
        $id_pengguna = session()->get('id_pengguna');
        $user = $penggunaModel->find($id_pengguna);

        // --- DINAMIS CEK ACHIEVEMENT / LENCANA (HALAMAN 27 PDF) ---
        $lencana = [
            'perisai_pertama' => false,
            'master_emosi'    => false,
            'penulis_harian'  => false
        ];

        if ($user['peran'] === 'siswa') {
            // 1. Perisai Pertama: Lulus Modul 1
            $modul1 = $db->table('progres_siswa')->where(['id_pengguna' => $id_pengguna, 'id_modul' => 1, 'status_modul' => 'selesai'])->get()->getRow();
            if ($modul1) $lencana['perisai_pertama'] = true;

            // 2. Master Emosi: Menyelesaikan minimal 5 Skenario/Mencoba Simulasi
            $totalSimulasi = $db->table('riwayat_simulasi')->where('id_pengguna', $id_pengguna)->countAllResults();
            if ($totalSimulasi >= 5) $lencana['master_emosi'] = true;

            // 3. Penulis Harian: Mengisi Jurnal Diary (Cek total isi diary atau streak)
            $totalJurnal = $db->table('log_suasana_hati')->where('id_pengguna', $id_pengguna)->countAllResults();
            if ($totalJurnal >= 7) $lencana['penulis_harian'] = true;
        }
        // -----------------------------------------------------------

        $data = [
            'user'    => $user,
            'lencana' => $lencana
        ];

        return view('profil/index', $data);
    }

    public function update()
    {
        if (!session()->get('logged_in')) return redirect()->to('/auth');

        $penggunaModel = new PenggunaModel();
        $id_pengguna = session()->get('id_pengguna');
        $user_lama = $penggunaModel->find($id_pengguna);

        $data_update = [
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'nama_panggilan' => $this->request->getPost('nama_panggilan'),
        ];

        // 1. Eksekusi Kolom Khusus (Guru/Admin)
        if ($this->request->getPost('nip') !== null) {
            $data_update['nip'] = $this->request->getPost('nip');
        }
        if ($this->request->getPost('jabatan') !== null) {
            $data_update['jabatan'] = $this->request->getPost('jabatan');
        }

        // 2. Logika Pembaruan Kata Sandi (Keamanan Ekstra)
        $password_lama = $this->request->getPost('kata_sandi_lama');
        $password_baru = $this->request->getPost('kata_sandi_baru');

        if (!empty($password_baru)) {
            // Wajib isi sandi lama
            if (empty($password_lama) || !password_verify($password_lama, $user_lama['kata_sandi'])) {
                session()->setFlashdata('pesan_gagal', 'Kata sandi lama salah atau tidak diisi!');
                return redirect()->to('/profil');
            }
            // Validasi Kompleksitas Sandi (Huruf besar, kecil, angka, tanda baca, min 8 karakter)
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password_baru)) {
                session()->setFlashdata('pesan_gagal', 'Kata sandi baru harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, serta tanda baca!');
                return redirect()->to('/profil');
            }
            $data_update['kata_sandi'] = password_hash($password_baru, PASSWORD_DEFAULT);
        }

        // 3. Logika Verifikasi Pos-el (Email)
        $email_baru = $this->request->getPost('email');
        if ($email_baru !== $user_lama['email']) {
            $token_verifikasi = bin2hex(random_bytes(32));
            $data_update['email'] = $email_baru;
            $data_update['token_verifikasi'] = $token_verifikasi;
            $data_update['status_aktif'] = 0; // Bekukan akun sampai diaktivasi
            
            // --- LOGIKA KIRIM EMAIL (Pastikan SMTP di .env sudah disetting) ---
            $email = \Config\Services::email();
            $email->setTo($email_baru);
            $email->setSubject('Verifikasi Email Baru - CyberGuard');
            $pesan = "Halo, klik tautan ini untuk verifikasi email baru Anda: <br>";
            $pesan .= "<a href='".site_url('auth/verifikasi/'.$token_verifikasi)."'>Verifikasi Email</a>";
            $email->setMessage($pesan);
            $email->send();
            
            session()->setFlashdata('pesan', 'Profil disimpan. Tautan verifikasi telah dikirim ke email baru Anda. Silakan login kembali setelah verifikasi.');
            
            // Jika email diganti, keluarkan pengguna karena butuh verifikasi
            $penggunaModel->update($id_pengguna, $data_update);
            return redirect()->to('/auth/logout'); 
        }

        // 4. Logika Simpan Foto Profil (Cropper.js Base64)
        $avatar_base64 = $this->request->getPost('avatar_base64');
        if (!empty($avatar_base64)) {
            $image_parts = explode(";base64,", $avatar_base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            $nama_avatar = 'avatar_' . $id_pengguna . '_' . time() . '.png';
            $path_avatar = 'uploads/avatars/' . $nama_avatar;
            
            file_put_contents(FCPATH . $path_avatar, $image_base64);
            $data_update['url_avatar'] = $path_avatar;
            
            if (!empty($user_lama['url_avatar']) && file_exists(FCPATH . $user_lama['url_avatar'])) {
                unlink(FCPATH . $user_lama['url_avatar']);
            }
        }

        $penggunaModel->update($id_pengguna, $data_update);
        session()->set('nama_lengkap', $data_update['nama_lengkap']);
        session()->set('nama_panggilan', $data_update['nama_panggilan']);
        if (isset($data_update['url_avatar'])) {
            session()->set('url_avatar', $data_update['url_avatar']);
        }

        session()->setFlashdata('pesan', 'Profil berhasil diperbarui!');
        return redirect()->to('/profil');
    }

    // ==========================================
    // FUNGSI SISWA BERGABUNG KE KELAS GURU BK
    // ==========================================
    public function gabung_kelas()
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');
        
        $db = \Config\Database::connect();
        
        // 1. Ambil inputan dari siswa
        $input_kode = (string) $this->request->getPost('kode_kelas');
        
        // 2. BERSIHKAN INPUT: Hapus spasi dan jadikan huruf kapital
        $kode_kelas = strtoupper(preg_replace('/\s+/', '', $input_kode));

        // 3. Percobaan Pertama: Cari kelas dengan kode asli
        $kelas = $db->table('kelas')->where('kode_kelas', $kode_kelas)->get()->getRowArray();
        
        // 4. Percobaan Kedua (Auto-Correct): Jika tidak ketemu, mungkin siswa keliru ketik huruf 'O' padahal angka '0'
        if (!$kelas) {
            $kode_koreksi = str_replace('O', '0', $kode_kelas); // Ubah O jadi 0
            $kelas = $db->table('kelas')->where('kode_kelas', $kode_koreksi)->get()->getRowArray();
        }
        
        if ($kelas) {
            // Jika kelas akhirnya ditemukan, tautkan profil siswa
            $db->table('pengguna')->where('id_pengguna', session()->get('id_pengguna'))->update([
                'id_kelas' => $kelas['id_kelas'],
                'id_guru'  => $kelas['id_guru']
            ]);
            session()->setFlashdata('pesan', 'Berhasil bergabung dengan kelas: ' . $kelas['nama_kelas']);
        } else {
            // Pesan error ini sekarang akan mencetak kode yang diketik siswa agar kamu bisa mengecek salahnya di mana
            session()->setFlashdata('pesan_gagal', "Kode [{$kode_kelas}] tidak ditemukan. Pastikan tidak ada salah ketik.");
        }
        
        return redirect()->to('/profil');
    }
}