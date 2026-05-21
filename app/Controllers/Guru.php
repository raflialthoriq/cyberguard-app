<?php
namespace App\Controllers;

class Guru extends BaseController
{
    // Pastikan semua fungsi dikunci HANYA untuk guru atau admin
    protected function cekAkses() {
        if (session()->get('peran') !== 'guru' && session()->get('peran') !== 'admin') {
            header('Location: /auth');
            exit;
        }
    }

    public function beranda() 
    {
        $this->cekAkses();
        
        $penggunaModel = new \App\Models\PenggunaModel();
        $id_guru = session()->get('id_pengguna');

        // 0. Tarik data guru untuk mengetahui dari sekolah mana dia berasal
        $data_guru = $penggunaModel->find($id_guru);
        $nama_sekolah_guru = $data_guru['nama_sekolah'];

        // 1. Hitung Total Siswa berdasarkan KESAMAAN SEKOLAH (Bukan id_guru)
        $total_siswa = $penggunaModel->where('peran', 'siswa')
                                     ->where('nama_sekolah', $nama_sekolah_guru)
                                     ->countAllResults();

        // 2. Hitung Siswa Perlu Perhatian (Berdasarkan sekolah yang sama)
        $batas_waktu = date('Y-m-d H:i:s', strtotime('-5 days'));
        
        $siswa_perhatian = $penggunaModel->where('peran', 'siswa')
                                         ->where('nama_sekolah', $nama_sekolah_guru)
                                         ->groupStart()
                                             ->where('terakhir_login <', $batas_waktu)
                                             ->orWhere('terakhir_login', null)
                                         ->groupEnd()
                                         ->countAllResults();

        // 3. Rata-rata progres (Sementara kita set 0)
        $rata_progres = 0;

        // Kirim data ke View
        $data = [
            'total_siswa' => $total_siswa,
            'siswa_perhatian' => $siswa_perhatian,
            'rata_progres' => $rata_progres
        ];

        return view('guru/beranda', $data);
    }

    // ==========================================
    // FUNGSI SIMPAN KELAS BARU
    // ==========================================
    public function simpan_kelas()
    {
        $this->cekAkses();
        $kelasModel = new \App\Models\KelasModel();
        
        // Buat Kode Kelas Acak (Contoh: CG-X8A2)
        $kode_acak = 'CG-' . strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4));

        $kelasModel->save([
            'id_guru'    => session()->get('id_pengguna'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'kode_kelas' => $kode_acak
        ]);

        session()->setFlashdata('pesan', 'Kelas berhasil dibuat! Kode Undangan: ' . $kode_acak);
        return redirect()->to('/guru/manajemen_kelas');
    }

    public function manajemen_kelas() 
    {
        $this->cekAkses();
        
        $kelasModel = new \App\Models\KelasModel();
        $penggunaModel = new \App\Models\PenggunaModel();
        $id_guru = session()->get('id_pengguna');

        // Ambil kelas asli dari database milik guru yang sedang login
        $kelas_db = $kelasModel->where('id_guru', $id_guru)->findAll();
        $daftar_kelas = [];

        foreach ($kelas_db as $k) {
            // Hitung jumlah siswa asli yang tergabung di kelas ini
            $jumlah_siswa = $penggunaModel->where('id_kelas', $k['id_kelas'])->countAllResults();
            $rata_progres = 0; // Sementara 0, karena tabel progres modul belum kita buat

            if ($rata_progres > 70) {
                $status_warna = 'text-green-500'; $status_bg = 'bg-green-100'; $status_teks = 'Aman';
            } elseif ($rata_progres >= 40 && $rata_progres <= 70) {
                $status_warna = 'text-yellow-500'; $status_bg = 'bg-yellow-100'; $status_teks = 'Waspada';
            } else {
                $status_warna = 'text-red-500'; $status_bg = 'bg-red-100'; $status_teks = 'Kritis';
            }

            $daftar_kelas[] = [
                'nama_kelas'   => $k['nama_kelas'],
                'kode_kelas'   => $k['kode_kelas'],
                'jumlah_siswa' => $jumlah_siswa,
                'rata_progres' => $rata_progres,
                'status_warna' => $status_warna,
                'status_bg'    => $status_bg,
                'status_teks'  => $status_teks
            ];
        }

        return view('guru/manajemen_kelas', ['daftar_kelas' => $daftar_kelas]);
    }

    public function intervensi_dini() 
    {
        $this->cekAkses();
        
        $penggunaModel = new \App\Models\PenggunaModel();
        $id_guru = session()->get('id_pengguna');

        // 1. Ambil nama sekolah guru
        $data_guru = $penggunaModel->find($id_guru);
        $nama_sekolah_guru = $data_guru['nama_sekolah'];

        // 2. Cari Siswa yang ter-flag (Kriteria sementara: Tidak login > 5 hari)
        $batas_waktu = date('Y-m-d H:i:s', strtotime('-5 days'));
        
        $siswa_bermasalah = $penggunaModel->where('peran', 'siswa')
                                          ->where('nama_sekolah', $nama_sekolah_guru)
                                          ->groupStart()
                                              ->where('terakhir_login <', $batas_waktu)
                                              ->orWhere('terakhir_login', null)
                                          ->groupEnd()
                                          ->findAll();

        // 3. Konversi Nama ke Inisial demi Privasi (Sesuai SOP Dokumen CyberGuard)
        $daftar_flagged = [];
        foreach ($siswa_bermasalah as $siswa) {
            
            // Ambil 2 huruf pertama dari nama lengkap
            $nama_parts = explode(' ', trim($siswa['nama_lengkap']));
            $inisial = strtoupper(substr($nama_parts[0], 0, 1));
            if (isset($nama_parts[1])) {
                $inisial .= strtoupper(substr($nama_parts[1], 0, 1));
            }

            $daftar_flagged[] = [
                'inisial'   => $inisial,
                'alasan'    => 'Tidak login lebih dari 5 hari.', // Nanti bisa ditambah: 'Skor mood rendah', dll.
                'keparahan' => 'high' // Bisa diatur dinamis: high/medium/low
            ];
        }

        return view('guru/intervensi_dini', ['daftar_flagged' => $daftar_flagged]);
    }

    public function panduan_fasilitator() {
        $this->cekAkses();
        // Menampilkan list PDF / Dokumen Panduan (Skenario Diskusi, dll)
        return view('guru/panduan_fasilitator');
    }

    public function laporan_cepat() 
    {
        $this->cekAkses();
        
        // Data mockup sesuai wireframe M7 di dokumen spesifikasi
        $data = [
            'filter_bulan' => 'Januari - Februari 2026',
            'sesi_simulasi_selesai' => '450x',
            'peningkatan_skor' => '+22%'
        ];

        return view('guru/laporan_cepat', $data);
    }
}