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
        // Jika sudah login, arahkan ke dashboard masing-masing
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
        $penggunaModel = new PenggunaModel();
        
        $email = $this->request->getPost('email');
        $password_input = $this->request->getPost('password'); 

        $user = $penggunaModel->where('email', $email)->first();

        // Verifikasi password
        if ($user && password_verify($password_input, $user['kata_sandi'])) {

            // Blokir jika akun disuspend (status 0 karena pelanggaran) atau belum verifikasi
            if (isset($user['status_aktif']) && $user['status_aktif'] == 0) {
                session()->setFlashdata('pesan_gagal', 'Akun Anda belum diverifikasi atau sedang ditangguhkan. Hubungi Admin.');
                return redirect()->to('/auth');
            }
            
            session()->set([
                'id_pengguna'    => $user['id_pengguna'],
                'nama_lengkap'   => $user['nama_lengkap'],
                'nama_panggilan' => $user['nama_panggilan'],
                'peran'          => $user['peran'],
                'url_avatar'     => $user['url_avatar'],
                'logged_in'      => true
            ]);

            if ($user['peran'] == 'admin') return redirect()->to('/admin/beranda');
            if ($user['peran'] == 'guru') return redirect()->to('/guru/beranda');
            return redirect()->to('/siswa/beranda');
        }
        
        session()->setFlashdata('pesan_gagal', 'Email atau Kata Sandi salah!');
        return redirect()->to('/auth');
    }

    // ==========================================
    // 2. REGISTRASI & KIRIM OTP WA
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
        $penggunaModel = new PenggunaModel();
        
        $email = $this->request->getPost('email');
        $no_wa = $this->request->getPost('no_wa');
        $password_input = $this->request->getPost('password');

        // Validasi Password Kuat
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password_input)) {
            session()->setFlashdata('pesan_gagal', 'Registrasi Gagal! Kata sandi minimal 8 karakter dan wajib mengandung huruf besar, huruf kecil, angka, serta simbol.');
            return redirect()->back()->withInput();
        }

        // Cek duplikasi Email & WA
        if ($penggunaModel->where('email', $email)->first()) {
            session()->setFlashdata('pesan_gagal', 'Email sudah terdaftar! Gunakan email lain.');
            return redirect()->back()->withInput();
        }
        if ($penggunaModel->where('no_wa', $no_wa)->first()) {
            session()->setFlashdata('pesan_gagal', 'Nomor WhatsApp sudah terdaftar! Gunakan nomor lain.');
            return redirect()->back()->withInput();
        }

        // Proteksi Autentikasi Sekolah untuk Guru
        if ($peran == 'guru') {
            $nama_sekolah = $this->request->getPost('nama_sekolah');
            $kode_rahasia_input = $this->request->getPost('kode_rahasia');

            $sekolahModel = new \App\Models\SekolahModel();
            $sekolah_db = $sekolahModel->where('nama_sekolah', $nama_sekolah)->first();

            if (!$sekolah_db || $kode_rahasia_input !== $sekolah_db['kode_otorisasi']) {
                session()->setFlashdata('pesan_gagal', 'Token sekolah tidak valid! Hubungi Admin Pusat.');
                return redirect()->back()->withInput();
            }
        }

        $nip_input = ($peran == 'guru') ? $this->request->getPost('nip') : null;
        
        // Buat Kode OTP WA
        $kode_otp = rand(100000, 999999);
        $pesanWA = "*Verifikasi CyberGuard* 🛡️\n\nKode OTP pendaftaran akun Anda adalah:\n\n*{$kode_otp}*\n\n_Mohon jangan berikan kode ini kepada siapapun demi keamanan akun Anda._";
        
        // Tembak API WA
        $this->kirim_notifikasi_wa($no_wa, $pesanWA);

        // Simpan data calon pengguna ke memory sementara (Session 5 Menit)
        session()->setTempdata('temp_register', [
            'nama_lengkap'   => $this->request->getPost('nama_lengkap'),
            'nama_panggilan' => $this->request->getPost('nama_panggilan'),
            'nama_sekolah'   => $this->request->getPost('nama_sekolah'),
            'nip'            => $nip_input,
            'email'          => $email,
            'no_wa'          => $no_wa,
            'kata_sandi'     => password_hash($password_input, PASSWORD_BCRYPT),
            'peran'          => $peran,
            'status_aktif'   => 1 // Akan langsung aktif jika OTP benar
        ], 300); 

        session()->setTempdata('otp_register', $kode_otp, 300);

        session()->setFlashdata('pesan_sukses', 'Kode OTP telah dikirim ke WhatsApp Anda. Silakan cek pesan masuk.');
        return redirect()->to('/auth/verifikasi_otp');
    }

    // ==========================================
    // 3. VERIFIKASI OTP WHATSAPP
    // ==========================================
    public function verifikasi_otp()
    {
        // Cegah akses langsung jika tidak ada sesi pendaftaran
        if (!session()->getTempdata('temp_register')) {
            session()->setFlashdata('pesan_gagal', 'Sesi pendaftaran kedaluwarsa (lebih dari 5 menit). Silakan daftar ulang.');
            return redirect()->to('/auth/register');
        }
        return view('auth/verifikasi_otp');
    }

    public function proses_verifikasi_otp()
    {
        $otp_input = $this->request->getPost('otp');
        $otp_session = session()->getTempdata('otp_register');
        $data_user = session()->getTempdata('temp_register');

        // Cek apakah waktu OTP habis
        if (!$data_user || !$otp_session) {
            session()->setFlashdata('pesan_gagal', 'Waktu pengisian OTP habis. Silakan daftar ulang.');
            return redirect()->to('/auth/register');
        }

        // Cek kecocokan OTP
        if ($otp_input == $otp_session) {
            $penggunaModel = new PenggunaModel();
            $penggunaModel->save($data_user); // Simpan permanen ke Database

            // Bersihkan sampah memory
            session()->removeTempdata('temp_register');
            session()->removeTempdata('otp_register');

            session()->setFlashdata('pesan_sukses', 'Verifikasi WhatsApp berhasil! Akun Anda telah aktif, silakan masuk.');
            return redirect()->to('/auth');
        } else {
            session()->setFlashdata('pesan_gagal', 'Kode OTP salah! Silakan coba lagi.');
            return redirect()->to('/auth/verifikasi_otp');
        }
    }

    // ==========================================
    // 4. LUPA PASSWORD (VIA EMAIL)
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

            $emailService = \Config\Services::email();
            $emailService->setTo($email);
            $emailService->setMailType('html');
            $emailService->setSubject('Reset Kata Sandi - CyberGuard');
            
            $link = base_url("/auth/reset_password/$token");
            $emailService->setMessage("Halo!<br>Kami menerima permintaan reset kata sandi akun Anda. Klik tautan ini untuk membuat kata sandi baru:<br><br><a href='$link' style='padding:10px 20px; background-color:#10B981; color:white; text-decoration:none; border-radius:5px;'>Reset Kata Sandi Sekarang</a>");
            
            $emailService->send();
        }

        session()->setFlashdata('pesan_sukses', 'Jika pos-el tersebut terdaftar, instruksi reset telah kami kirimkan ke kotak masuk Anda.');
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

    // ==========================================
    // 5. API WHATSAPP FONNTE HELPER
    // ==========================================
    private function kirim_notifikasi_wa($no_wa, $pesan) 
    {
        if (empty($no_wa)) return false;

        $token = 'MASUKKAN_TOKEN_FONNTE_KAMU_DI_SINI'; // GANTI DENGAN TOKEN FONNTE MILIKMU
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $no_wa,
                'message' => $pesan,
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}