<?php
namespace App\Controllers;
use App\Models\PenggunaModel;

class Profil extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/auth');

        $penggunaModel = new PenggunaModel();
        $data['user'] = $penggunaModel->find(session()->get('id_pengguna'));
        
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
}