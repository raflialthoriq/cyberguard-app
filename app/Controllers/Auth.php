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

        if ($user && password_verify($password_input, $user['kata_sandi'])) {

            // Jika kata sandi benar tetapi status akun masih belum aktif (0)
            if (isset($user['status_aktif']) && $user['status_aktif'] == 0) {
                
                // Cek jika sudah verifikasi WhatsApp tapi belum klik link email
                if (!empty($user['token_verifikasi']) && empty($user['otp_code'])) {
                    session()->setFlashdata('pesan_gagal', 'Verifikasi WhatsApp Anda sudah berhasil. Mohon periksa kotak masuk atau spam email Anda untuk mengklik tautan aktivasi akun agar dapat masuk.');
                    return redirect()->to('/auth');
                }

                // MEKANISME RE-GENERATE OTP BARU (OTP LAMA OTOMATIS HANGUS)
                $kode_otp = rand(100000, 999999);
                $expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                
                $penggunaModel->update($user['id_pengguna'], [
                    'otp_code' => $kode_otp,
                    'otp_expired_at' => $expired_time
                ]);

                $pesanWA = "*Aktivasi Akun CyberGuard* 🛡️\n\nAkun Anda belum aktif sepenuhnya. Berikut adalah kode OTP verifikasi WhatsApp baru Anda:\n\n*{$kode_otp}*\n\n_Kode ini berlaku selama 30 menit dari sekarang._";
                $this->kirim_notifikasi_wa($user['no_wa'], $pesanWA);

                session()->set('otp_verify_user_id', $user['id_pengguna']);
                session()->setFlashdata('pesan_sukses', 'Akun Anda belum aktif. Kode OTP baru telah dikirimkan ke nomor WhatsApp Anda.');
                return redirect()->to('/auth/verifikasi_otp');
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

        if ($penggunaModel->where('email', $email)->first()) {
            session()->setFlashdata('pesan_gagal', 'Alamat email sudah terdaftar! Gunakan email lain.');
            return redirect()->back()->withInput();
        }
        if ($penggunaModel->where('no_wa', $no_wa)->first()) {
            session()->setFlashdata('pesan_gagal', 'Nomor WhatsApp sudah terdaftar! Gunakan nomor lain.');
            return redirect()->back()->withInput();
        }

        if ($peran == 'guru') {
            $nama_sekolah = $this->request->getPost('nama_sekolah');
            $kode_rahasia_input = $this->request->getPost('kode_rahasia');

            $sekolahModel = new \App\Models\SekolahModel();
            $sekolah_db = $sekolahModel->where('nama_sekolah', $nama_sekolah)->first();

            if (!$sekolah_db || $kode_rahasia_input !== $sekolah_db['kode_otorisasi']) {
                session()->setFlashdata('pesan_gagal', 'Token otorisasi sekolah tidak valid!');
                return redirect()->back()->withInput();
            }
        }

        $nip_input = ($peran == 'guru') ? $this->request->getPost('nip') : null;
        $id_guru_input = ($peran == 'siswa') ? $this->request->getPost('id_guru') : null;
        $id_guru_bersih = (!empty($id_guru_input)) ? $id_guru_input : null;

        // Pembuatan Kode OTP WA & Token Email
        $kode_otp = rand(100000, 999999);
        $email_token = bin2hex(random_bytes(32));
        $expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Simpan langsung ke database dengan status tidak aktif (0) agar aman dari bug session
        $penggunaModel->save([
            'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
            'nama_panggilan'   => $this->request->getPost('nama_panggilan'),
            'nama_sekolah'     => $this->request->getPost('nama_sekolah'),
            'nip'              => $nip_input,
            'id_guru'          => $id_guru_bersih,
            'email'            => $email,
            'no_wa'            => $no_wa,
            'kata_sandi'       => password_hash($password_input, PASSWORD_BCRYPT),
            'peran'            => $peran,
            'status_aktif'     => 0, 
            'token_verifikasi' => $email_token,
            'otp_code'         => $kode_otp,
            'otp_expired_at'   => $expired_time
        ]);

        $inserted_id = $penggunaModel->getInsertID();

        // 1. Tembak Kode OTP ke WhatsApp
        $pesanWA = "*Verifikasi Pendaftaran Akun CyberGuard* 🛡️\n\nHalo *{$this->request->getPost('nama_lengkap')}*,\n\nBerikut adalah kode OTP verifikasi WhatsApp Anda:\n\n*{$kode_otp}*\n\n_Kode ini rahasia, berlaku selama 30 menit. Silakan masukkan kode ini pada halaman verifikasi aplikasi._";
        $this->kirim_notifikasi_wa($no_wa, $pesanWA);

        // 2. Tembak Link Validasi ke Email (Format Formal & Pendekatan Psikologis)
        $emailService = \Config\Services::email();
        $emailService->setFrom(env('email.SMTPUser') ?? 'ptriwindasari@gmail.com', 'Admin CyberGuard');
        $emailService->setTo($email);
        $emailService->setMailType('html'); 
        $emailService->setSubject('✉️ Langkah Terakhir: Validasi Email Akun CyberGuard');
        
        $link = base_url("/auth/verifikasi/$email_token");
        $pesanEmail = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px;'>
            <h2 style='color: #10b981; border-bottom: 2px solid #10b981; padding-bottom: 10px;'>Selamat Datang di CyberGuard</h2>
            <p>Halo, " . esc($this->request->getPost('nama_lengkap')) . "</p>
            <p>Terima kasih telah mengambil langkah awal yang luar biasa untuk bergabung dalam ekosistem pelindung ruang digital dan kesehatan psikologis remaja bersama CyberGuard.</p>
            <p>Untuk memastikan keabsahan korespondensi data dan keamanan akun Anda, mohon lakukan konfirmasi email dengan mengeklik tautan resmi di bawah ini:</p>
            <div style='text-align: center; margin: 30px 0;'>
                <a href='$link' style='padding: 12px 24px; background-color: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Validasi & Aktifkan Email Saya</a>
            </div>
            <p>Setelah Anda menyelesaikan verifikasi kode OTP WhatsApp di aplikasi, pastikan Anda juga menekan tombol di atas agar akun dapat digunakan sepenuhnya.</p>
            <br>
            <p>Salam hangat,<br><strong>Tim Pengembang CyberGuard</strong></p>
        </div>";
        $emailService->setMessage($pesanEmail);
        $emailService->send();

        session()->set('otp_verify_user_id', $inserted_id);
        session()->setFlashdata('pesan_sukses', 'Pendaftaran awal berhasil! Silakan masukkan kode OTP WhatsApp Anda, dan periksa email untuk validasi tautan.');
        return redirect()->to('/auth/verifikasi_otp');
    }

    public function verifikasi($token)
    {
        $penggunaModel = new PenggunaModel();
        $user = $penggunaModel->where('token_verifikasi', $token)->first();

        if ($user) {
            // Pastikan dia sudah lolos OTP WA terlebih dahulu
            if (!empty($user['otp_code'])) {
                session()->setFlashdata('pesan_gagal', 'Anda wajib menyelesaikan verifikasi kode OTP WhatsApp terlebih dahulu sebelum mengaktifkan tautan email.');
                return redirect()->to('/auth');
            }

            $penggunaModel->update($user['id_pengguna'], [
                'status_aktif' => 1,
                'token_verifikasi' => null
            ]);
            session()->setFlashdata('pesan_sukses', 'Email berhasil divalidasi! Akun CyberGuard Anda telah aktif sepenuhnya. Silakan masuk.');
        } else {
            session()->setFlashdata('pesan_gagal', 'Tautan verifikasi tidak valid atau akun sudah aktif.');
        }
        return redirect()->to('/auth');
    }

    // ==========================================
    // 3. VERIFIKASI OTP WHATSAPP
    // ==========================================

    public function verifikasi_otp()
    {
        if (!session()->get('otp_verify_user_id')) {
            session()->setFlashdata('pesan_gagal', 'Silakan melakukan login atau registrasi terlebih dahulu.');
            return redirect()->to('/auth');
        }
        return view('auth/verifikasi_otp');
    }

public function proses_verifikasi_otp()
    {
        $otp_input = $this->request->getPost('otp');
        $id_user = session()->get('otp_verify_user_id');

        if (!$id_user) {
            session()->setFlashdata('pesan_gagal', 'Sesi verifikasi tidak valid.');
            return redirect()->to('/auth');
        }

        $penggunaModel = new PenggunaModel();
        $user = $penggunaModel->find($id_user);

        if (!$user) {
            session()->setFlashdata('pesan_gagal', 'Data pengguna tidak ditemukan.');
            return redirect()->to('/auth');
        }

        // Cek Batas Waktu 30 Menit
        $waktu_sekarang = date('Y-m-d H:i:s');
        if ($waktu_sekarang > $user['otp_expired_at'] || empty($user['otp_code'])) {
            session()->setFlashdata('pesan_gagal', 'Kode OTP salah atau sudah kedaluwarsa. Silakan login kembali untuk menerima OTP baru.');
            return redirect()->to('/auth/verifikasi_otp');
        }

        if ($otp_input == $user['otp_code']) {
            // Sukses OTP WA: Kosongkan field OTP agar tidak bisa dipakai ulang
            $penggunaModel->update($id_user, [
                'otp_code' => null,
                'otp_expired_at' => null
            ]);

            session()->setFlashdata('pesan_sukses', 'Verifikasi WhatsApp berhasil dikunci! Langkah terakhir, silakan buka kotak masuk atau folder spam email Anda untuk mengklik tautan aktivasi akun.');
            return redirect()->to('/auth');
        } else {
            session()->setFlashdata('pesan_gagal', 'Kode OTP yang Anda masukkan salah.');
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

        // VALIDASI TOLAK JIKA EMAIL TIDAK ADA DI DATABASE
        if (!$user) {
            session()->setFlashdata('pesan_gagal', 'Alamat email tidak terdaftar dalam sistem kami!');
            return redirect()->back()->withInput();
        }

        $token = bin2hex(random_bytes(32));
        $expired = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $penggunaModel->update($user['id_pengguna'], [
            'token_reset' => $token,
            'reset_kedaluwarsa' => $expired
        ]);

        $emailService = \Config\Services::email();
        $emailService->setFrom(env('email.SMTPUser') ?? 'ptriwindasari@gmail.com', 'Admin CyberGuard');
        $emailService->setTo($email);
        
        // WAJIB SET FORMAT HTML AGAR EMAIL MASUK SECARA SEMPURNA
        $emailService->setMailType('html');
        $emailService->setSubject('🔐 Pemulihan Kata Sandi Akun - CyberGuard');
        
        // PERBAIKAN: Mengarahkan ke rute reset_password yang benar, bukan rute verifikasi akun baru!
        $link = base_url("/auth/reset_password/$token");
        
        $pesanHTML = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px;'>
            <h2 style='color: #2b6cb0; border-bottom: 2px solid #2b6cb0; padding-bottom: 10px;'>Permintaan Pemulihan Kata Sandi</h2>
            <p>Halo, " . esc($user['nama_lengkap']) . "</p>
            <p>Kami menerima permintaan untuk menyetel ulang kata sandi akun CyberGuard Anda. Kami memahami bahwa kenyamanan akses ke platform perlindungan ini sangat penting bagi Anda.</p>
            <p>Silakan klik tombol di bawah ini untuk membuat kata sandi baru. Tautan ini berlaku selama 1 jam dari sekarang:</p>
            <div style='text-align: center; margin: 30px 0;'>
                <a href='$link' style='padding: 12px 24px; background-color: #2b6cb0; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Atur Ulang Kata Sandi</a>
            </div>
            <p style='color: #718096; font-size: 12px;'>Jika Anda tidak merasa mengajukan permintaan ini, abaikan email ini dengan aman. Kata sandi Anda tidak akan berubah.</p>
            <br>
            <p>Salam hangat,<br><strong>Tim Manajemen CyberGuard</strong></p>
        </div>";
        
        $emailService->setMessage($pesanHTML);
        $emailService->send();

        session()->setFlashdata('pesan_sukses', 'Instruksi pemulihan kata sandi telah berhasil dikirim ke email terdaftar Anda.');
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
   // ==========================================
    // FUNGSI PENEMBAK API WHATSAPP (FONNTE)
    // ==========================================
private function kirim_notifikasi_wa($no_wa, $pesan) 
    {
        if (empty($no_wa)) return false;
        $token = 'SubHsSjfWkd7bBvURMLB'; 
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $no_wa, 'message' => $pesan, 'countryCode' => '62'),
            CURLOPT_HTTPHEADER => array('Authorization: ' . $token),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}