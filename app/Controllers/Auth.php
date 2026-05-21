<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    // ==========================================
    // 1. LOGIN
    // ==========================================
    public function index()
    {
        // Jika sudah login, cek perannya
        if (session()->get('logged_in')) {
        $peran = session()->get('peran');
        if ($peran == 'admin') return redirect()->to('/admin/beranda');
        if ($peran == 'guru') return redirect()->to('/guru/beranda');
        return redirect()->to('/siswa/beranda');
    }
        return view('auth/login');
    }

    public function login_proses()
    {
        $penggunaModel = new \App\Models\PenggunaModel();
        
        // 1. Definisikan variabel input dari form login
        $email = $this->request->getPost('email');
        $password_input = $this->request->getPost('password'); // Ini variabel yang hilang tadi

        // 2. Cari user berdasarkan email
        $user = $penggunaModel->where('email', $email)->first();

        // 3. Verifikasi password
        if ($user && password_verify($password_input, $user['kata_sandi'])) {

        if (isset($user['status_aktif']) && $user['status_aktif'] == 0) {
            session()->setFlashdata('pesan_gagal', 'Akses Ditolak! Akun Anda telah ditangguhkan karena melanggar ketentuan kami. Hubungi Admin.');
            return redirect()->to('/auth');
        }
            
            // Cek apakah email sudah diverifikasi (status_aktif = 1)
            if ($user['status_aktif'] == 0) {
                session()->setFlashdata('pesan_gagal', 'Akun belum aktif! Silakan cek kotak masuk/spam email Anda untuk verifikasi.');
                return redirect()->to('/auth');
            }
            

            // Set session jika berhasil login
            session()->set([
                'id_pengguna'    => $user['id_pengguna'],
                'nama_lengkap'   => $user['nama_lengkap'],
                'nama_panggilan' => $user['nama_panggilan'],
                'peran'          => $user['peran'],
                'url_avatar'     => $user['url_avatar'],
                'logged_in'      => true
            ]);

            
            // 4. Arahkan ke dashboard masing-masing sesuai hak akses (RBAC)
            if ($user['peran'] == 'admin') {
                return redirect()->to('/admin/beranda');
            } elseif ($user['peran'] == 'guru') {
                return redirect()->to('/guru/beranda');
            } else {
                return redirect()->to('/siswa/beranda');
            }
        }
        
        // Jika email tidak ada atau password salah
        session()->setFlashdata('pesan_gagal', 'Email atau Password salah!');
        return redirect()->to('/auth');
    }

    // ==========================================
    // 2. REGISTRASI SISWA & GURU
    // ==========================================
    public function register()
    {
        $sekolahModel = new \App\Models\SekolahModel();
        return view('auth/register', ['daftar_sekolah' => $sekolahModel->findAll()]);
    }

    public function register_guru()
    {
        $sekolahModel = new \App\Models\SekolahModel();
        return view('auth/register_guru', ['daftar_sekolah' => $sekolahModel->findAll()]);
    }

   public function register_proses($peran = 'siswa')
    {
        $penggunaModel = new \App\Models\PenggunaModel();
        
        // 1. AMBIL INPUT DARI FORM
        $email = $this->request->getPost('email');
        $password_input = $this->request->getPost('password'); // Ini variabel yang hilang tadi

        // 2. VALIDASI PASSWORD KUAT (Min 8 karakter, Huruf Besar, Kecil, Angka, Simbol)
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password_input)) {
            session()->setFlashdata('pesan_gagal', 'Registrasi Gagal! Kata sandi minimal 8 karakter dan wajib mengandung huruf besar, huruf kecil, angka, serta simbol.');
            return redirect()->back()->withInput();
        }

        // 3. CEK EMAIL GANDA
        if ($penggunaModel->where('email', $email)->first()) {
            session()->setFlashdata('pesan_gagal', 'Pos-el sudah terdaftar! Gunakan pos-el lain.');
            return redirect()->back()->withInput();
        }

        // 4. PROTEKSI GURU (Cek Kode Otorisasi Sekolah)
        if ($peran == 'guru') {
            $nama_sekolah = $this->request->getPost('nama_sekolah');
            $kode_rahasia_input = $this->request->getPost('kode_rahasia');

            $sekolahModel = new \App\Models\SekolahModel();
            $sekolah_db = $sekolahModel->where('nama_sekolah', $nama_sekolah)->first();

            if (!$sekolah_db || $kode_rahasia_input !== $sekolah_db['kode_otorisasi']) {
                session()->setFlashdata('pesan_gagal', 'Token tidak valid! Hubungi Admin Pusat.');
                return redirect()->back()->withInput();
            }
        }

        // 5. SOLUSI LOGIKA NIP vs ID GURU (Mencegah Error 1452)
        $nip_input = ($peran == 'guru') ? $this->request->getPost('nip') : null;
        $id_guru_input = ($peran == 'siswa') ? $this->request->getPost('id_guru') : null;
        $id_guru_bersih = (!empty($id_guru_input)) ? $id_guru_input : null;

        $token = bin2hex(random_bytes(32)); 
        
        // 6. SIMPAN KE DATABASE
        $penggunaModel->save([
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'nama_panggilan' => $this->request->getPost('nama_panggilan'),
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'nip'            => $nip_input,
            'id_guru'        => $id_guru_bersih,
            'email'          => $email,
            'kata_sandi'     => password_hash($password_input, PASSWORD_BCRYPT),
            'peran'          => $peran,
            'status_aktif'   => 0, 
            'token_verifikasi' => $token
        ]);

        // 7. KIRIM EMAIL VERIFIKASI
        $emailService = \Config\Services::email();
        $emailService->setFrom(env('email.SMTPUser'), 'Admin CyberGuard'); 
        $emailService->setTo($email);
        $emailService->setMailType('html'); 
        $emailService->setSubject('Verifikasi Akun CyberGuard');
        
        $link = base_url("/auth/verifikasi/$token");
        $emailService->setMessage("Halo! Klik tautan ini untuk mengaktifkan akun Anda:<br><br><a href='$link' style='padding:10px 20px; background-color:#10B981; color:white; text-decoration:none; border-radius:5px; display:inline-block; margin-top:10px;'>Verifikasi Akun Sekarang</a>");
        
        $emailService->send();

        session()->setFlashdata('pesan_sukses', 'Pendaftaran berhasil! Cek kotak pos-el Anda untuk aktivasi.');
        return redirect()->to('/auth');
    }

    public function verifikasi($token)
    {
        $penggunaModel = new PenggunaModel();
        $user = $penggunaModel->where('token_verifikasi', $token)->first();

        if ($user) {
            $penggunaModel->update($user['id_pengguna'], [
                'status_aktif' => 1,
                'token_verifikasi' => null
            ]);
            session()->setFlashdata('pesan_sukses', 'Pos-el berhasil diverifikasi! Silakan masuk.');
        } else {
            session()->setFlashdata('pesan_gagal', 'Token tidak valid atau akun sudah diverifikasi.');
        }
        return redirect()->to('/auth');
    }

    // ==========================================
    // 3. LUPA PASSWORD
    // ==========================================
    public function lupa_password()
    {
        return view('auth/lupa_password');
    }

    public function proses_lupa_password()
    {
        $penggunaModel = new PenggunaModel();
        $email = $this->request->getPost('email');
        $user = $penggunaModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expired = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $penggunaModel->update($user['id_pengguna'], [
                'token_reset' => $token,
                'reset_kedaluwarsa' => $expired
            ]);

            // KIRIM EMAIL VERIFIKASI
        $emailService = \Config\Services::email();
        $emailService->setFrom('ptriwindasari@gmail.com', 'Admin CyberGuard');
        $emailService->setTo($email);
        $emailService->setMailType('html');
        $emailService->setSubject('Verifikasi Akun CyberGuard');
        $link = base_url("/auth/verifikasi/$token");
        $emailService->setMessage("Halo! Klik tautan ini untuk mengaktifkan akun Anda:<br><br><a href='$link' style='padding:10px 20px; background-color:#10B981; color:white; text-decoration:none; border-radius:5px;'>Verifikasi Akun Sekarang</a>");
        
        if ($emailService->send()) {
            session()->setFlashdata('pesan_sukses', 'Registrasi akun berhasil! Periksa pos-el Anda untuk aktivasi.');
            return redirect()->to('/auth');
        } else {
            // Ini akan memunculkan teks merah panjang yang berisi alasan kenapa email gagal dikirim
            echo $emailService->printDebugger(['headers']);
            exit; 
        }
        }

        // Sengaja diberi pesan sukses meski email tak ada untuk mencegah hacker menebak email
        session()->setFlashdata('pesan_sukses', 'Jika pos-el terdaftar, instruksi reset telah dikirim.');
        return redirect()->to('/auth');
    }

    public function reset_password($token)
    {
        $penggunaModel = new PenggunaModel();
        $user = $penggunaModel->where('token_reset', $token)->where('reset_kedaluwarsa >=', date('Y-m-d H:i:s'))->first();

        if (!$user) {
            session()->setFlashdata('pesan_gagal', 'Token reset tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/auth');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    public function proses_ganti_password()
    {
        $penggunaModel = new PenggunaModel();
        $token = $this->request->getPost('token');
        $user = $penggunaModel->where('token_reset', $token)->first();

        if ($user) {
            $penggunaModel->update($user['id_pengguna'], [
                'kata_sandi' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'token_reset' => null,
                'reset_kedaluwarsa' => null
            ]);
            session()->setFlashdata('pesan_sukses', 'Kata sandi berhasil diubah! Silakan masuk dengan kata sandi baru.');
        }
        return redirect()->to('/auth');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}