<?php
namespace App\Controllers;

class Guru extends BaseController
{
    protected function cekAkses() {
        if (session()->get('peran') !== 'guru' && session()->get('peran') !== 'admin') {
            header('Location: /auth');
            exit;
        }
    }

    // ==========================================
    // BERANDA GURU DENGAN GRAFIK AKTIVITAS DINAMIS
    // ==========================================
    public function beranda() 
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $total_siswa = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru, 'status_aktif' => 1])->countAllResults();
        
        $batas_waktu = date('Y-m-d H:i:s', strtotime('-5 days'));
        $siswa_perhatian = $db->table('pengguna')
                              ->where('peran', 'siswa')
                              ->where('id_guru', $id_guru)
                              ->groupStart()
                                  ->where('terakhir_login <', $batas_waktu)
                                  ->orWhere('terakhir_login', null)
                                  ->orWhere('skor_kesejahteraan <', 50)
                              ->groupEnd()
                              ->countAllResults();

        $total_modul = $db->table('modul_belajar')->countAllResults();
        $rata_progres = 0;
        if ($total_siswa > 0 && $total_modul > 0) {
            $total_selesai = $db->query("SELECT COUNT(ps.id_progres) as total FROM progres_siswa ps JOIN pengguna p ON ps.id_pengguna = p.id_pengguna WHERE p.id_guru = ? AND ps.status_modul = 'selesai'", [$id_guru])->getRowArray()['total'];
            $rata_progres = round(($total_selesai / ($total_siswa * $total_modul)) * 100);
        }

        // PEMBARUAN: Hitung Aktivitas Real-Time 7 Hari Terakhir untuk Grafik Batang
        $aktivitas_harian = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal_target = date('Y-m-d', strtotime("-$i days"));
            $hari_nama = date('D', strtotime($tanggal_target));
            
            $jumlah_aktif = $db->query("
                SELECT COUNT(DISTINCT ps.id_pengguna) as total 
                FROM progres_siswa ps
                JOIN pengguna p ON ps.id_pengguna = p.id_pengguna
                WHERE p.id_guru = ? AND DATE(ps.tanggal_selesai) = ?
            ", [$id_guru, $tanggal_target])->getRowArray()['total'] ?? 0;

            $aktivitas_harian[] = [
                'hari' => $hari_nama,
                'jumlah' => (int)$jumlah_aktif
            ];
        }

        return view('guru/beranda', [
            'total_siswa' => $total_siswa,
            'siswa_perhatian' => $siswa_perhatian,
            'rata_progres' => $rata_progres,
            'aktivitas_harian' => $aktivitas_harian
        ]);
    }

    public function simpan_kelas()
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        
        $kode_kelas = 'CG-' . strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4));
        
        $db->table('kelas')->insert([
            'id_guru'      => session()->get('id_pengguna'),
            'nama_kelas'   => $this->request->getPost('nama_kelas'),
            'kode_kelas'   => $kode_kelas,
            'status_kelas' => 'buka'
        ]);

        session()->setFlashdata('pesan', 'Ruang kelas baru berhasil diterbitkan.');
        return redirect()->to('/guru/manajemen_kelas');
    }

    public function refresh_kode_kelas($id_kelas)
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $kode_baru = 'CG-' . strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4));
        
        $db->table('kelas')->where(['id_kelas' => $id_kelas, 'id_guru' => session()->get('id_pengguna')])->update(['kode_kelas' => $kode_baru]);
        session()->setFlashdata('pesan', 'Kode undangan kelas berhasil diperbarui menjadi: ' . $kode_baru);
        return redirect()->to('/guru/manajemen_kelas');
    }

    public function tutup_kelas($id_kelas)
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        
        $kelas = $db->table('kelas')->where(['id_kelas' => $id_kelas, 'id_guru' => session()->get('id_pengguna')])->get()->getRowArray();
        $status_baru = ($kelas['status_kelas'] === 'buka') ? 'tutup' : 'buka';
        
        $db->table('kelas')->where('id_kelas', $id_kelas)->update(['status_kelas' => $status_baru]);
        session()->setFlashdata('pesan', 'Akses pendaftaran kelas berhasil diubah menjadi: di-' . $status_baru);
        return redirect()->to('/guru/manajemen_kelas');
    }

    public function total_siswa_aktif()
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $data['judul'] = "Daftar Seluruh Siswa Aktif Bimbingan";
        $data['siswa'] = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru, 'status_aktif' => 1])->get()->getResultArray();
        return view('guru/list_siswa_dashboard', $data);
    }

    public function siswa_perhatian()
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');
        $batas_waktu = date('Y-m-d H:i:s', strtotime('-5 days'));

        $data['judul'] = "Siswa Memerlukan Intervensi Mendedak";
        $data['siswa'] = $db->table('pengguna')
                            ->where('peran', 'siswa')
                            ->where('id_guru', $id_guru)
                            ->groupStart()
                                ->where('terakhir_login <', $batas_waktu)
                                ->orWhere('terakhir_login', null)
                                ->orWhere('skor_kesejahteraan <', 50)
                            ->groupEnd()
                            ->get()->getResultArray();
        return view('guru/list_siswa_dashboard', $data);
    }

    public function manajemen_kelas() 
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $kelas_db = $db->table('kelas')->where('id_guru', $id_guru)->get()->getResultArray();
        $total_modul = $db->table('modul_belajar')->countAllResults();
        $daftar_kelas = [];

        foreach ($kelas_db as $k) {
            $jumlah_siswa = $db->table('pengguna')->where(['id_kelas' => $k['id_kelas'], 'status_aktif' => 1])->countAllResults();
            $persen_progres = 0;

            if ($jumlah_siswa > 0 && $total_modul > 0) {
                $selesai = $db->query("SELECT COUNT(ps.id_progres) as total FROM progres_siswa ps JOIN pengguna p ON ps.id_pengguna = p.id_pengguna WHERE p.id_kelas = ? AND ps.status_modul = 'selesai'", [$k['id_kelas']])->getRowArray()['total'];
                $persen_progres = round(($selesai / ($jumlah_siswa * $total_modul)) * 100);
            }

            $daftar_kelas[] = [
                'id_kelas'     => $k['id_kelas'],
                'nama_kelas'   => $k['nama_kelas'],
                'kode_kelas'   => $k['kode_kelas'],
                'status_kelas' => $k['status_kelas'] ?? 'buka',
                'jumlah_siswa' => $jumlah_siswa,
                'rata_progres' => $persen_progres
            ];
        }

        return view('guru/manajemen_kelas', ['daftar_kelas' => $daftar_kelas]);
    }

    public function detail_kelas($id_kelas)
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        
        $kelas = $db->table('kelas')->where('id_kelas', $id_kelas)->get()->getRowArray();
        if (!$kelas) return redirect()->to('/guru/manajemen_kelas');

        $daftar_siswa = $db->table('pengguna')
                           ->where(['id_kelas' => $id_kelas, 'peran' => 'siswa'])
                           ->orderBy('nama_lengkap', 'ASC')
                           ->get()->getResultArray();

        return view('guru/detail_kelas', [
            'kelas' => $kelas,
            'daftar_siswa' => $daftar_siswa
        ]);
    }

    public function detail_siswa($id_siswa)
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        
        $siswa = $db->table('pengguna')->where('id_pengguna', $id_siswa)->get()->getRowArray();
        $progres = $db->query("SELECT ps.*, m.judul_modul FROM progres_siswa ps JOIN modul_belajar m ON ps.id_modul = m.id_modul WHERE ps.id_pengguna = ?", [$id_siswa])->getResultArray();
        $simulasi = $db->query("SELECT rs.*, s.judul_simulasi as judul_skenario FROM riwayat_simulasi rs JOIN skenario_simulasi s ON rs.id_skenario = s.id_skenario WHERE rs.id_pengguna = ?", [$id_siswa])->getResultArray();

        return view('guru/detail_siswa', [
            'siswa' => $siswa,
            'progres' => $progres,
            'simulasi' => $simulasi
        ]);
    }

 public function intervensi_dini() 
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $batas_waktu = date('Y-m-d H:i:s', strtotime('-5 days'));
        
        // Ambil data siswa bermasalah (Join dengan tabel kelas untuk ambil nama kelas)
        $siswa_bermasalah = $db->query("
            SELECT p.*, k.nama_kelas 
            FROM pengguna p
            LEFT JOIN kelas k ON p.id_kelas = k.id_kelas
            WHERE p.peran = 'siswa' AND p.id_guru = ? 
            AND (p.terakhir_login < ? OR p.terakhir_login IS NULL OR p.skor_kesejahteraan < 50)
        ", [$id_guru, $batas_waktu])->getResultArray();

        // LOGIKA COOLDOWN 7 HARI (Evaluasi Pekan Depan)
        // Cari siswa yang sudah dibuatkan jadwal dalam 7 hari terakhir
        $jadwal_minggu_ini = $db->table('jadwal_konseling')
                                ->where('id_guru', $id_guru)
                                ->where('dibuat_pada >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                                ->get()->getResultArray();
        $siswa_diproses = array_column($jadwal_minggu_ini, 'id_siswa');

        $daftar_flagged = [];
        foreach ($siswa_bermasalah as $siswa) {
            $alasan = [];
            if (!$siswa['terakhir_login'] || $siswa['terakhir_login'] < $batas_waktu) $alasan[] = 'Tidak aktif login > 5 hari';
            if ($siswa['skor_kesejahteraan'] < 50) $alasan[] = 'Skor kesejahteraan psikologis kritis';

            // Cek apakah siswa ini masuk ke dalam daftar yang sudah diproses minggu ini
            $is_processed = in_array($siswa['id_pengguna'], $siswa_diproses);

            $daftar_flagged[] = [
                'id_siswa'   => $siswa['id_pengguna'],
                'nama'       => $siswa['nama_lengkap'],
                'email'      => $siswa['email'],
                'nama_kelas' => $siswa['nama_kelas'] ?? 'Belum ada kelas',
                'skor'       => $siswa['skor_kesejahteraan'],
                'alasan'     => implode(' & ', $alasan),
                'keparahan'  => ($siswa['skor_kesejahteraan'] < 40) ? 'high' : 'medium',
                'is_processed' => $is_processed // Penanda untuk dikirim ke View
            ];
        }

        $jadwal = $db->query("SELECT jk.*, p.nama_lengkap FROM jadwal_konseling jk JOIN pengguna p ON jk.id_siswa = p.id_pengguna WHERE jk.id_guru = ? ORDER BY jk.tanggal_konseling ASC", [$id_guru])->getResultArray();

        return view('guru/intervensi_dini', [
            'daftar_flagged' => $daftar_flagged,
            'daftar_jadwal'  => $jadwal
        ]);
    }

   public function simpan_jadwal_konseling()
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        
        $id_siswa = $this->request->getPost('id_siswa');
        $tgl = $this->request->getPost('tanggal_konseling');
        $cat = $this->request->getPost('catatan');

        $db->table('jadwal_konseling')->insert([
            'id_guru'           => session()->get('id_pengguna'),
            'id_siswa'          => $id_siswa,
            'tanggal_konseling' => $tgl,
            'catatan'           => $cat,
            'status'            => 'direncanakan'
        ]);

        // 1. Kumpulkan Data Siswa
        $siswa = $db->table('pengguna')->where('id_pengguna', $id_siswa)->get()->getRowArray();

        // 2. Eksekusi Notifikasi Email (Fungsi yang sudah kita buat sebelumnya)
        $this->kirim_notifikasi_email($id_siswa, $tgl, $cat);
        
        // 3. Eksekusi Notifikasi WhatsApp
        if (!empty($siswa['no_wa'])) {
            $pesanWA = "*Panggilan Bimbingan CyberGuard* 🚨\n\nHalo *{$siswa['nama_lengkap']}*,\nKami berharap pesan ini menemuimu dalam keadaan baik. Di CyberGuard, kami percaya bahwa menjaga kesehatan mental sama pentingnya dengan menjaga kesehatan fisik. Berdasarkan evaluasi dari aktivitas belajarmu baru-baru ini, Guru Bimbingan dan Konseling (BK) ingin mengundangmu untuk sesi diskusi ringan dan tertutup pada:\n\n🗓️ Waktu: *" . date('d F Y, H:i', strtotime($tgl)) . " WIB*\n📍 Lokasi/Catatan: *{$cat}*\n\nTujuan dari sesi ini adalah untuk mendengarkan, memberikan dukungan, dan memastikan kamu memiliki ruang yang aman untuk bercerita. Kehadiranmu sangat berarti bagi kami. Jika kamu memiliki kendala terkait jadwal ini, jangan ragu untuk menemui Guru BK terkait. \nTetap semangat!";
            
            $this->kirim_notifikasi_wa($siswa['no_wa'], $pesanWA);
        }
        
        session()->setFlashdata('pesan', 'Jadwal berhasil dikunci. Undangan via Email & WhatsApp otomatis dikirim ke siswa.');
        return redirect()->to('/guru/intervensi_dini');
    }

    // ==========================================
    // INTEGRASI LAPORAN & EKSPOR DATA RIIL (AKURAT)
    // ==========================================
 public function laporan_cepat() 
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $filter_kelas = $this->request->getGet('kelas');
        $filter_waktu = $this->request->getGet('waktu'); // format: YYYY-MM

        $data['daftar_kelas'] = $db->table('kelas')->where('id_guru', $id_guru)->get()->getResultArray();
        
        $builder = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru]);
        if (!empty($filter_kelas)) $builder->where('id_kelas', $filter_kelas);
        $siswa_list = $builder->get()->getResultArray();

        $laporan = [];
        foreach($siswa_list as $s) {
            $id_s = $s['id_pengguna'];
            
            // Perbaikan Query: Menyaring progres belajar secara akurat berdasarkan parameter bulan/tahun
            $q_modul = "SELECT AVG(skor_kuis) as rata, COUNT(id_progres) as total FROM progres_siswa WHERE id_pengguna = ? AND status_modul='selesai'";
            $params_modul = [$id_s];
            if (!empty($filter_waktu)) {
                $q_modul .= " AND tanggal_selesai LIKE ?";
                $params_modul[] = $filter_waktu . '%';
            }
            $stat_modul = $db->query($q_modul, $params_modul)->getRowArray();

            $q_simulasi = "SELECT SUM(skor_kontrol_diri) as total_poin FROM riwayat_simulasi WHERE id_pengguna = ?";
            $params_simulasi = [$id_s];
            if (!empty($filter_waktu)) {
                $q_simulasi .= " AND tanggal_percobaan LIKE ?";
                $params_simulasi[] = $filter_waktu . '%';
            }
            $stat_simulasi = $db->query($q_simulasi, $params_simulasi)->getRowArray();

            $laporan[] = [
                'nama' => $s['nama_lengkap'],
                'email' => $s['email'],
                'skor_mental' => $s['skor_kesejahteraan'],
                'modul_selesai' => $stat_modul['total'] ?? 0,
                'rata_kuis' => round($stat_modul['rata'] ?? 0),
                'poin_cbt' => $stat_simulasi['total_poin'] ?? 0,
                'login_terakhir' => $s['terakhir_login']
            ];
        }

        $data['laporan'] = $laporan;
        $data['filter_kelas'] = $filter_kelas;
        $data['filter_waktu'] = $filter_waktu;
        return view('guru/laporan_cepat', $data);
    }

    public function ekspor_laporan($format)
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $id_guru = session()->get('id_pengguna');

        $siswa_list = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru])->get()->getResultArray();
        
        $data_export = [];
        foreach($siswa_list as $s) {
            $id_s = $s['id_pengguna'];
            $kelas = $db->table('kelas')->where('id_kelas', $s['id_kelas'])->get()->getRowArray();
            $nama_kelas = $kelas ? $kelas['nama_kelas'] : 'Tanpa Kelas';
            
            $stat_modul = $db->query("SELECT AVG(skor_kuis) as rata_kuis, COUNT(id_progres) as total_modul FROM progres_siswa WHERE id_pengguna = $id_s AND status_modul='selesai'")->getRowArray();
            $stat_simulasi = $db->query("SELECT SUM(skor_kontrol_diri) as total_poin_cbt FROM riwayat_simulasi WHERE id_pengguna = $id_s")->getRowArray();

            $data_export[] = [
                'Nama Lengkap' => $s['nama_lengkap'],
                'Kelas' => $nama_kelas,
                'Skor Kesejahteraan' => $s['skor_kesejahteraan'],
                'Modul Selesai' => $stat_modul['total_modul'] ?? 0,
                'Rata Kuis' => round($stat_modul['rata_kuis'] ?? 0),
                'Total Poin CBT' => $stat_simulasi['total_poin_cbt'] ?? 0
            ];
        }

        $filename = "Laporan_GuruBK_" . date('Y-m-d');

        if ($format === 'csv') {
            header("Content-Disposition: attachment; filename=$filename.csv");
            header("Content-Type: text/csv; charset=UTF-8");
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, array_keys($data_export[0]));
            foreach ($data_export as $row) fputcsv($file, $row);
            fclose($file);
            exit;
        } elseif ($format === 'excel') {
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "<table border='1'><tr>";
            foreach (array_keys($data_export[0]) as $h) echo "<th style='background:#f4f4f4;'>$h</th>";
            echo "</tr>";
            foreach ($data_export as $row) {
                echo "<tr>";
                foreach ($row as $val) echo "<td>$val</td>";
                echo "</tr>";
            }
            echo "</table>";
            exit;
        } elseif ($format === 'pdf') {
            return view('guru/laporan_cetak_pdf', ['data' => $data_export]);
        }
    }

    public function panduan_fasilitator() {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $data['daftar_panduan'] = $db->table('panduan_guru')->orderBy('kode_panduan', 'ASC')->get()->getResultArray();
        return view('guru/panduan_fasilitator', $data);
    }

    public function baca_panduan($id_panduan) {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $data['panduan'] = $db->table('panduan_guru')->where('id_panduan', $id_panduan)->get()->getRowArray();
        return view('guru/baca_panduan', $data);
    }

    // Tambahkan fungsi di Guru.php untuk mengirim Email ke Siswa
    public function kirim_notifikasi_email($id_siswa, $tanggal, $catatan) 
    {
        $db = \Config\Database::connect();
        $siswa = $db->table('pengguna')->where('id_pengguna', $id_siswa)->get()->getRowArray();
        
        if (!$siswa || empty($siswa['email'])) return false;

        $email = \Config\Services::email();
        $email->setFrom('ptriwindasari@gmail.com', 'CyberGuard System'); 
        $email->setTo($siswa['email']);
        $email->setSubject('Undangan Sesi Bimbingan & Konseling - CyberGuard');
        
        // WAJIB DITAMBAHKAN AGAR TAG HTML TERBACA
        $email->setMailType('html'); 

        // Isi email dengan bahasa yang suportif dan formal
        $pesanHTML = "
        <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px;'>
            <h2 style='color: #2b6cb0; border-bottom: 2px solid #2b6cb0; padding-bottom: 10px;'>Halo, " . esc($siswa['nama_lengkap']) . "</h2>
            <p>Kami berharap pesan ini menemuimu dalam keadaan baik.</p>
            <p>Di CyberGuard, kami percaya bahwa menjaga kesehatan mental sama pentingnya dengan menjaga kesehatan fisik. Berdasarkan evaluasi dari aktivitas belajarmu baru-baru ini, Guru Bimbingan dan Konseling (BK) ingin mengundangmu untuk sesi diskusi ringan dan tertutup.</p>
            <p>Tujuan dari sesi ini adalah untuk mendengarkan, memberikan dukungan, dan memastikan kamu memiliki ruang yang aman untuk bercerita.</p>
            <div style='background-color: #f7fafc; padding: 15px; border-radius: 8px; margin: 20px 0;'>
                <p style='margin: 5px 0;'><strong>🗓️ Waktu:</strong> " . date('d F Y, H:i', strtotime($tanggal)) . " WIB</p>
                <p style='margin: 5px 0;'><strong>📍 Lokasi/Catatan:</strong> " . esc($catatan) . "</p>
            </div>
            <p>Kehadiranmu sangat berarti bagi kami. Jika kamu memiliki kendala terkait jadwal ini, jangan ragu untuk menemui Guru BK terkait.</p>
            <br>
            <p>Salam hangat,<br><strong>Tim Fasilitator CyberGuard</strong></p>
        </div>";
        
        $email->setMessage($pesanHTML);
        return $email->send();
    }

    // FUNGSI API WHATSAPP
 // ==========================================
    // FUNGSI PENEMBAK API WHATSAPP (FONNTE)
    // ==========================================
    private function kirim_notifikasi_wa($no_wa, $pesan) 
    {
        if (empty($no_wa)) return false;

        // PASTIKAN TOKEN INI SUDAH DIGANTI DENGAN TOKEN ASLI MILIKMU DARI DASHBOARD FONNTE
        $token = 'SubHsSjfWkd7bBvURMLB'; 
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30, // Beri waktu toleransi 30 detik
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $no_wa,
                'message' => $pesan,
                'countryCode' => '62', // Memaksa format Indonesia
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
            // ========================================================
            // BARIS WAJIB UNTUK XAMPP/LOCALHOST AGAR HTTPS TIDAK DIBLOKIR
            // ========================================================
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        
        // PENCATATAN ERROR (DEBUGGER)
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            log_message('error', 'Fonnte cURL Gagal: ' . $error_msg);
        } else {
            // Catat balasan dari Fonnte (Bisa dilihat di folder writable/logs/)
            log_message('info', 'Fonnte Response: ' . $response);
        }

        curl_close($curl);
        return $response;
    }


}