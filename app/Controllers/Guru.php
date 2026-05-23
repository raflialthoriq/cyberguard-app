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

        // 1. Total Siswa Berdasarkan Relasi ID Guru Bimbingan
        $total_siswa = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru, 'status_aktif' => 1])->countAllResults();
        
        // 2. Siswa Perlu Perhatian Berdasarkan Relasi ID Guru
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

        // 3. Grafik Aktivitas Harian Siswa Minggu Ini (Dinamis Nyata dari Progres & Simulasi)
        $aktivitas_minggu_ini = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal_target = date('Y-m-d', strtotime("-$i days"));
            $nama_hari = date('D', strtotime($tanggal_target));
            
            $aktif_hari_ini = $db->query("
                SELECT COUNT(DISTINCT ps.id_pengguna) as total 
                FROM progres_siswa ps 
                JOIN pengguna p ON ps.id_pengguna = p.id_pengguna
                WHERE p.id_guru = ? AND (DATE(ps.tanggal_selesai) = ? )
            ", [$id_guru, $tanggal_target])->getRowArray()['total'] ?? 0;

            $aktivitas_minggu_ini[] = [
                'hari' => $nama_hari,
                'jumlah' => $aktif_hari_ini
            ];
        }

        return view('guru/beranda', [
            'total_siswa' => $total_siswa,
            'siswa_perhatian' => $siswa_perhatian,
            'rata_progres' => $rata_progres,
            'aktivitas_minggu_ini' => $aktivitas_minggu_ini
        ]);
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
        $siswa_bermasalah = $db->table('pengguna')
                              ->where(['peran' => 'siswa', 'id_guru' => $id_guru])
                              ->groupStart()
                                  ->where('terakhir_login <', $batas_waktu)
                                  ->orWhere('terakhir_login', null)
                                  ->orWhere('skor_kesejahteraan <', 50)
                              ->groupEnd()
                              ->get()->getResultArray();

        $daftar_flagged = [];
        foreach ($siswa_bermasalah as $siswa) {
            $nama_parts = explode(' ', trim($siswa['nama_lengkap']));
            $inisial = strtoupper(substr($nama_parts[0], 0, 1));
            if (isset($nama_parts[1])) $inisial .= strtoupper(substr($nama_parts[1], 0, 1));

            $alasan = [];
            if (!$siswa['terakhir_login'] || $siswa['terakhir_login'] < $batas_waktu) $alasan[] = 'Tidak aktif login';
            if ($siswa['skor_kesejahteraan'] < 50) $alasan[] = 'Skor kesejahteraan kritis';

            $daftar_flagged[] = [
                'id_siswa' => $siswa['id_pengguna'],
                'nama' => $siswa['nama_lengkap'],
                'skor' => $siswa['skor_kesejahteraan'],
                'inisial' => $inisial,
                'alasan' => implode(' & ', $alasan),
                'keparahan' => ($siswa['skor_kesejahteraan'] < 40) ? 'high' : 'medium'
            ];
        }

        $jadwal = $db->query("SELECT jk.*, p.nama_lengkap FROM jadwal_konseling jk JOIN pengguna p ON jk.id_siswa = p.id_pengguna WHERE jk.id_guru = ? ORDER BY jk.tanggal_konseling ASC", [$id_guru])->getResultArray();

        return view('guru/intervensi_dini', [
            'daftar_flagged' => $daftar_flagged,
            'daftar_jadwal' => $jadwal
        ]);
    }

    public function simpan_jadwal_konseling()
    {
        $this->cekAkses();
        $db = \Config\Database::connect();
        $db->table('jadwal_konseling')->insert([
            'id_guru' => session()->get('id_pengguna'),
            'id_siswa' => $this->request->getPost('id_siswa'),
            'tanggal_konseling' => $this->request->getPost('tanggal_konseling'),
            'catatan' => $this->request->getPost('catatan'),
            'status' => 'direncanakan'
        ]);
        session()->setFlashdata('pesan', 'Jadwal konseling berhasil dikunci.');
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
        $filter_waktu = $this->request->getGet('waktu');

        $data['daftar_kelas'] = $db->table('kelas')->where('id_guru', $id_guru)->get()->getResultArray();
        
        $builder = $db->table('pengguna')->where(['peran' => 'siswa', 'id_guru' => $id_guru]);
        if (!empty($filter_kelas)) $builder->where('id_kelas', $filter_kelas);
        $siswa_list = $builder->get()->getResultArray();

        $data_laporan = [];
        foreach($siswa_list as $s) {
            $id_s = $s['id_pengguna'];
            
            $q_progres = "SELECT AVG(skor_kuis) as rata_kuis, COUNT(id_progres) as total_modul FROM progres_siswa WHERE id_pengguna = $id_s AND status_modul='selesai'";
            if(!empty($filter_waktu)) $q_progres .= " AND tanggal_selesai LIKE '$filter_waktu%'";
            $stat_modul = $db->query($q_progres)->getRowArray();

            $q_simulasi = "SELECT SUM(skor_kontrol_diri) as total_poin_cbt FROM riwayat_simulasi WHERE id_pengguna = $id_s";
            if(!empty($filter_waktu)) $q_simulasi .= " AND tanggal_percobaan LIKE '$filter_waktu%'";
            $stat_simulasi = $db->query($q_simulasi)->getRowArray();

            $data_laporan[] = [
                'nama' => $s['nama_lengkap'],
                'email' => $s['email'],
                'skor_mental' => $s['skor_kesejahteraan'],
                'modul_selesai' => $stat_modul['total_modul'] ?? 0,
                'rata_kuis' => round($stat_modul['rata_kuis'] ?? 0),
                'poin_cbt' => $stat_simulasi['total_poin_cbt'] ?? 0,
                'login_terakhir' => $s['terakhir_login']
            ];
        }

        $data['laporan'] = $data_laporan;
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
    
    $email = \Config\Services::email();
    $email->setTo($siswa['email']);
    $email->setSubject('Undangan Konseling BK - CyberGuard');
    $email->setMessage("Halo {$siswa['nama_lengkap']}, Anda dijadwalkan untuk konseling BK pada {$tanggal}. Catatan: {$catatan}. Mohon hadir tepat waktu.");
    
    return $email->send();
}

// Update fungsi simpan_jadwal_konseling
public function simpan_jadwal_konseling()
{
    $this->cekAkses();
    $db = \Config\Database::connect();
    
    $id_siswa = $this->request->getPost('id_siswa');
    $tgl = $this->request->getPost('tanggal_konseling');
    $cat = $this->request->getPost('catatan');

    $db->table('jadwal_konseling')->insert([
        'id_guru' => session()->get('id_pengguna'),
        'id_siswa' => $id_siswa,
        'tanggal_konseling' => $tgl,
        'catatan' => $cat,
        'status' => 'direncanakan'
    ]);

    // Otomatis kirim email
    $this->kirim_notifikasi_email($id_siswa, $tgl, $cat);
    
    session()->setFlashdata('pesan', 'Jadwal tersimpan & email undangan telah dikirim ke siswa.');
    return redirect()->to('/guru/intervensi_dini');
}
}