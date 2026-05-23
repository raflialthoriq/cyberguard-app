<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModulBelajarModel;

class Admin extends BaseController
{
    public function beranda()
    {
       if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
    }

    $db = \Config\Database::connect();
    $penggunaModel = new \App\Models\PenggunaModel();
    $modulModel = new \App\Models\ModulBelajarModel();

    // =========================================================
        // 1. AMBIL DATA UNTUK GRAFIK MODUL SECARA DINAMIS
        // =========================================================
        // Query: Ambil semua judul modul, dan hitung berapa banyak siswa yang statusnya 'selesai' di modul tersebut
        $queryModul = $db->query("
            SELECT m.judul_modul, 
                   (SELECT COUNT(p.id_progres) 
                    FROM progres_siswa p 
                    WHERE p.id_modul = m.id_modul AND p.status_modul = 'selesai') as jumlah_selesai
            FROM modul_belajar m
            ORDER BY m.urutan_modul ASC
        ")->getResultArray();

        $array_nama_modul = [];
        $array_jumlah_siswa_selesai = [];
        $total_siswa_lulus_modul = 0; // Untuk statistik teks di atas

        foreach ($queryModul as $row) {
            $array_nama_modul[] = $row['judul_modul'];
            $array_jumlah_siswa_selesai[] = (int) $row['jumlah_selesai'];
            $total_siswa_lulus_modul += (int) $row['jumlah_selesai'];
        }

        // Jika tabel modul masih kosong sama sekali, beri nilai default agar grafik tidak error
        if (empty($array_nama_modul)) {
            $array_nama_modul = ['Belum ada modul'];
            $array_jumlah_siswa_selesai = [0];
        }

        // =========================================================
        // 2. AMBIL DATA UNTUK GRAFIK KUESIONER SECARA DINAMIS
        // =========================================================
        // Query: Ambil judul kuesioner dan hitung total partisipan
        $queryKuesioner = $db->query("
            SELECT k.judul_kuesioner, 
                   COUNT(pk.id_partisipasi) as jumlah_responden
            FROM kuesioner k
            LEFT JOIN partisipasi_kuesioner pk ON k.id_kuesioner = pk.id_kuesioner
            GROUP BY k.id_kuesioner, k.judul_kuesioner
            ORDER BY k.dibuat_pada ASC
        ")->getResultArray();

        $array_nama_kuesioner = [];
        $array_jumlah_responden = [];
        $total_responden = 0;

        foreach ($queryKuesioner as $row) {
            $array_nama_kuesioner[] = $row['judul_kuesioner'];
            $array_jumlah_responden[] = (int) $row['jumlah_responden'];
            $total_responden += (int) $row['jumlah_responden'];
        }

        if (empty($array_nama_kuesioner)) {
            $array_nama_kuesioner = ['Belum ada kuesioner'];
            $array_jumlah_responden = [0];
        }

        // Kirim data ke View
        $data = [
            'array_nama_modul'           => $array_nama_modul,
            'array_jumlah_siswa_selesai' => $array_jumlah_siswa_selesai,
            'array_nama_kuesioner'       => $array_nama_kuesioner,
            'array_jumlah_responden'     => $array_jumlah_responden,
            
            // Variabel ini untuk angka tebal di atas grafik (Card Statistik)
            'total_modul_selesai'        => $total_siswa_lulus_modul,
            'total_kuesioner_diisi'      => $total_responden
        ];


        // 1. Ambil Statistik Dasar
        // Menghitung total akun dengan peran 'siswa'
        $data['total_siswa'] = $penggunaModel->where('peran', 'siswa')->countAllResults();
        $data['total_modul'] = $modulModel->countAllResults();

        // Menghitung Rata-rata Skor Kuis Seluruh Siswa
        $query_rata_kuis = $db->query("SELECT AVG(skor_kuis) as rata_rata FROM progres_siswa WHERE status_modul = 'selesai'")->getRow();
        $data['rata_kuis'] = $query_rata_kuis->rata_rata ? round($query_rata_kuis->rata_rata) : 0;

        // 2. Ambil 5 Progres Kuis Terbaru (JOIN 3 Tabel)
        $builder_progres = $db->table('progres_siswa');
        $builder_progres->select('progres_siswa.*, pengguna.nama_lengkap, modul_belajar.judul_modul');
        $builder_progres->join('pengguna', 'pengguna.id_pengguna = progres_siswa.id_pengguna');
        $builder_progres->join('modul_belajar', 'modul_belajar.id_modul = progres_siswa.id_modul');
        $builder_progres->orderBy('tanggal_selesai', 'DESC');
        $builder_progres->limit(5);
        $data['progres_terbaru'] = $builder_progres->get()->getResultArray();

        // 3. Ambil 5 Riwayat Simulasi CBT Terbaru (JOIN 3 Tabel)
        $builder_simulasi = $db->table('riwayat_simulasi');
        $builder_simulasi->select('riwayat_simulasi.*, pengguna.nama_lengkap, skenario_simulasi.judul_simulasi');
        $builder_simulasi->join('pengguna', 'pengguna.id_pengguna = riwayat_simulasi.id_pengguna');
        $builder_simulasi->join('skenario_simulasi', 'skenario_simulasi.id_skenario = riwayat_simulasi.id_skenario');
        $builder_simulasi->orderBy('tanggal_percobaan', 'DESC');
        $builder_simulasi->limit(5);
        $data['simulasi_terbaru'] = $builder_simulasi->get()->getResultArray();

        return view('admin/beranda', $data);
    }
    
// Fungsi untuk menampilkan daftar modul yang ada di database
    public function kelola_modul()
    {
        // Pastikan hanya admin yang bisa akses
        if (session()->get('peran') !== 'admin') {
            return redirect()->to('/auth');
        }

        $modulModel = new ModulBelajarModel();
        
        $data = [
            'daftar_modul' => $modulModel->orderBy('urutan_modul', 'ASC')->findAll()
        ];

        return view('admin/kelola_modul', $data);
    }

    // Fungsi untuk menampilkan halaman form tambah modul
    public function tambah_modul()
    {
        if (session()->get('peran') !== 'admin') {
            return redirect()->to('/auth');
        }

        return view('admin/tambah_modul');
    }

    // Fungsi untuk memproses data dari form dan menyimpannya ke database
    public function simpan_modul()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}

        $modulModel = new ModulBelajarModel();
        
        // Ambil input tipe media
        $tipe_media = $this->request->getPost('tipe_media');
        $nama_file = null;
        $url_youtube = $this->request->getPost('url_youtube');

        // Logika Upload File (Jika tipe media adalah gambar, dokumen, atau audio)
        if (in_array($tipe_media, ['gambar', 'dokumen', 'audio'])) {
            $file = $this->request->getFile('file_media');
            // Cek apakah ada file yang diunggah dan tidak ada error
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                // Generate nama file acak agar tidak bentrok
                $nama_file = $file->getRandomName();
                // Pindahkan file ke folder public/uploads/modul
                $file->move('uploads/modul', $nama_file);
            }
        }

        // Menyimpan data ke database
        $modulModel->save([
            'judul_modul'   => $this->request->getPost('judul_modul'),
            'urutan_modul'  => $this->request->getPost('urutan_modul'),
            'konten_materi' => $this->request->getPost('konten_materi'),
            'tipe_media'    => $tipe_media,
            'file_media'    => $nama_file,
            'url_youtube'   => $url_youtube
        ]);

        session()->setFlashdata('pesan', 'Modul multimedia berhasil ditambahkan!');
        return redirect()->to('/admin/kelola_modul');
    }

    // ==========================================
    // LANJUTAN CRUD MODUL
    // ==========================================
    
    public function hapus_modul($id_modul)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $modulModel = new ModulBelajarModel();
        
        // Opsional: Hapus file fisik jika ada
        $modul = $modulModel->find($id_modul);
        if ($modul && in_array($modul['tipe_media'], ['gambar', 'dokumen', 'audio']) && !empty($modul['file_media'])) {
            $path = 'uploads/modul/' . $modul['file_media'];
            if (file_exists($path)) unlink($path);
        }

        $modulModel->delete($id_modul);
        session()->setFlashdata('pesan', 'Modul berhasil dihapus!');
        return redirect()->to('/admin/kelola_modul');
    }

    public function edit_modul($id_modul)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $modulModel = new ModulBelajarModel();
        $data['modul'] = $modulModel->find($id_modul);
        return view('admin/edit_modul', $data);
    }

    public function update_modul($id_modul)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $modulModel = new ModulBelajarModel();
        $modul_lama = $modulModel->find($id_modul);
        
        $tipe_media = $this->request->getPost('tipe_media');
        $url_youtube = $this->request->getPost('url_youtube');
        $nama_file = $modul_lama['file_media']; // Secara default, pertahankan file lama

        // Jika tipe media butuh file (gambar, dokumen, audio)
        if (in_array($tipe_media, ['gambar', 'dokumen', 'audio'])) {
            $file = $this->request->getFile('file_media');
            
            // Cek apakah ada file BARU yang diunggah
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                $nama_file = $file->getRandomName();
                $file->move('uploads/modul', $nama_file);
                
                // Hapus file lama dari server untuk menghemat memori
                if (!empty($modul_lama['file_media']) && file_exists('uploads/modul/' . $modul_lama['file_media'])) {
                    unlink('uploads/modul/' . $modul_lama['file_media']);
                }
            }
        } else {
            // Jika diganti menjadi "Teks" atau "YouTube", hapus file fisik lama (jika ada) dan kosongkan nama_file
            if (!empty($modul_lama['file_media']) && file_exists('uploads/modul/' . $modul_lama['file_media'])) {
                unlink('uploads/modul/' . $modul_lama['file_media']);
            }
            $nama_file = null;
        }

        // Jika bukan youtube, pastikan url_youtube dikosongkan
        if ($tipe_media !== 'youtube') {
            $url_youtube = null;
        }

        $modulModel->update($id_modul, [
            'judul_modul'   => $this->request->getPost('judul_modul'),
            'urutan_modul'  => $this->request->getPost('urutan_modul'),
            'konten_materi' => $this->request->getPost('konten_materi'),
            'tipe_media'    => $tipe_media,
            'file_media'    => $nama_file,
            'url_youtube'   => $url_youtube
        ]);

        session()->setFlashdata('pesan', 'Modul beserta medianya berhasil diperbarui!');
        return redirect()->to('/admin/kelola_modul');
    }

    // ==========================================
    // CRUD SKENARIO SIMULASI
    // ==========================================

    public function kelola_simulasi()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $simulasiModel = new \App\Models\SkenarioSimulasiModel();
        $data['daftar_simulasi'] = $simulasiModel->findAll();
        return view('admin/kelola_simulasi', $data);
    }

    public function tambah_simulasi()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        return view('admin/tambah_simulasi');
    }

    public function hapus_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $simulasiModel = new \App\Models\SkenarioSimulasiModel();
        $simulasiModel->delete($id_skenario);
        session()->setFlashdata('pesan', 'Skenario Simulasi berhasil dihapus!');
        return redirect()->to('/admin/kelola_simulasi');
    }
    public function simpan_simulasi()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $simulasiModel = new \App\Models\SkenarioSimulasiModel();
        $opsiModel = new \App\Models\OpsiSimulasiModel();

        // 1. Simpan kasus utamanya dulu
        $simulasiModel->insert([
            'judul_simulasi'  => $this->request->getPost('judul_simulasi'),
            'deskripsi_kasus' => $this->request->getPost('deskripsi_kasus'),
        ]);
        
        $id_skenario_baru = $simulasiModel->getInsertID();

        // 2. Tangkap input opsi yang berbentuk Array dari form dinamis
        $teks_opsi = $this->request->getPost('teks_opsi');
        $feedback_opsi = $this->request->getPost('feedback_opsi');
        $skor_opsi = $this->request->getPost('skor_opsi');

        // 3. Looping dan simpan semua opsi tersebut ke tabel opsi_simulasi
        if (!empty($teks_opsi)) {
            for ($i = 0; $i < count($teks_opsi); $i++) {
                $opsiModel->save([
                    'id_skenario'   => $id_skenario_baru,
                    'teks_opsi'     => $teks_opsi[$i],
                    'feedback_opsi' => $feedback_opsi[$i],
                    'skor_opsi'     => $skor_opsi[$i]
                ]);
            }
        }

        session()->setFlashdata('pesan', 'Skenario beserta opsi dinamisnya berhasil ditambahkan!');
        return redirect()->to('/admin/kelola_simulasi');
    }

    public function edit_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $simulasiModel = new \App\Models\SkenarioSimulasiModel();
        $opsiModel = new \App\Models\OpsiSimulasiModel();
        
        $data['skenario'] = $simulasiModel->find($id_skenario);
        $data['daftar_opsi'] = $opsiModel->where('id_skenario', $id_skenario)->findAll();
        
        return view('admin/edit_simulasi', $data);
    }

    public function update_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $simulasiModel = new \App\Models\SkenarioSimulasiModel();
        $opsiModel = new \App\Models\OpsiSimulasiModel();

        // 1. Update kasus utama
        $simulasiModel->update($id_skenario, [
            'judul_simulasi'  => $this->request->getPost('judul_simulasi'),
            'deskripsi_kasus' => $this->request->getPost('deskripsi_kasus')
        ]);

        // 2. Hapus semua opsi lama terkait skenario ini
        $opsiModel->where('id_skenario', $id_skenario)->delete();

        // 3. Masukkan kembali opsi-opsi yang baru/diperbarui
        $teks_opsi = $this->request->getPost('teks_opsi');
        $feedback_opsi = $this->request->getPost('feedback_opsi');
        $skor_opsi = $this->request->getPost('skor_opsi');

        if (!empty($teks_opsi)) {
            for ($i = 0; $i < count($teks_opsi); $i++) {
                $opsiModel->save([
                    'id_skenario'   => $id_skenario,
                    'teks_opsi'     => $teks_opsi[$i],
                    'feedback_opsi' => $feedback_opsi[$i],
                    'skor_opsi'     => $skor_opsi[$i]
                ]);
            }
        }

        session()->setFlashdata('pesan', 'Skenario berhasil diperbarui!');
        return redirect()->to('/admin/kelola_simulasi');
    }

    // ==========================================
    // CRUD SOAL KUIS MODUL
    // ==========================================

    public function kelola_kuis($id_modul)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $modulModel = new \App\Models\ModulBelajarModel();
        $soalModel = new \App\Models\SoalKuisModel();

        $data['modul'] = $modulModel->find($id_modul);
        $data['daftar_soal'] = $soalModel->where('id_modul', $id_modul)->findAll();

        return view('admin/kelola_kuis', $data);
    }

    public function simpan_kuis($id_modul)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $soalModel = new \App\Models\SoalKuisModel();

        $soalModel->save([
            'id_modul'      => $id_modul,
            'pertanyaan'    => $this->request->getPost('pertanyaan'),
            'opsi_a'        => $this->request->getPost('opsi_a'),
            'opsi_b'        => $this->request->getPost('opsi_b'),
            'opsi_c'        => $this->request->getPost('opsi_c'),
            'jawaban_benar' => $this->request->getPost('jawaban_benar')
        ]);

        session()->setFlashdata('pesan', 'Soal kuis baru berhasil ditambahkan!');
        return redirect()->to('/admin/kelola_kuis/' . $id_modul);
    }

    public function hapus_kuis($id_soal)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $soalModel = new \App\Models\SoalKuisModel();
        $soal = $soalModel->find($id_soal);
        $id_modul = $soal['id_modul']; // Simpan id_modul sebelum dihapus untuk redirect
        
        $soalModel->delete($id_soal);

        session()->setFlashdata('pesan', 'Soal berhasil dihapus!');
        return redirect()->to('/admin/kelola_kuis/' . $id_modul);
    }

    // ==========================================
    // PEMANTAUAN JURNAL SISWA (DEKRIPSI AES-256)
    // ==========================================
    public function kelola_jurnal()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}

        $db = \Config\Database::connect();
        
        // Ambil data jurnal gabungkan dengan nama siswa
        $builder = $db->table('log_suasana_hati');
        $builder->select('log_suasana_hati.*, pengguna.nama_lengkap, pengguna.nama_panggilan');
        $builder->join('pengguna', 'pengguna.id_pengguna = log_suasana_hati.id_pengguna');
        $builder->orderBy('tanggal_jurnal', 'DESC');
        $jurnal_mentah = $builder->get()->getResultArray();

        $kunci_enkripsi = env('encryption.key');
        $jurnal_bersih = [];

        foreach ($jurnal_mentah as $jurnal) {
            $teks_enkripsi_full = $jurnal['teks_jurnal'];
            
            // Proses Dekripsi (Membuka Sandi)
            $parts = explode('::', base64_decode($teks_enkripsi_full));
            if (count($parts) === 2) {
                $iv = $parts[0];
                $teks_terenkripsi = $parts[1];
                $jurnal['teks_asli'] = openssl_decrypt($teks_terenkripsi, 'aes-256-cbc', $kunci_enkripsi, 0, $iv);
            } else {
                $jurnal['teks_asli'] = "⚠️ (Data korup atau kunci enkripsi tidak cocok)";
            }

            // Ubah emoji suasana hati menjadi teks yang lebih jelas
            $mood = $jurnal['suasana_hati'];
            if ($mood == 'senang') $jurnal['ikon_mood'] = '😄 Senang';
            elseif ($mood == 'sedih') $jurnal['ikon_mood'] = '😢 Sedih';
            elseif ($mood == 'marah') $jurnal['ikon_mood'] = '😡 Marah';
            elseif ($mood == 'cemas') $jurnal['ikon_mood'] = '😰 Cemas';
            else $jurnal['ikon_mood'] = '😐 Biasa Saja';

            $jurnal_bersih[] = $jurnal;
        }

        return view('admin/kelola_jurnal', ['daftar_jurnal' => $jurnal_bersih]);
    }

    // ==========================================
    // MANAJEMEN DATA SEKOLAH
    // ==========================================
    public function kelola_sekolah()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $sekolahModel = new \App\Models\SekolahModel();
        return view('admin/kelola_sekolah', ['daftar_sekolah' => $sekolahModel->findAll()]);
    }

    public function simpan_sekolah()
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $sekolahModel = new \App\Models\SekolahModel();
        
        // Buat 6 karakter kode acak (Kombinasi Huruf Besar & Angka)
        $kode_acak = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        
        $sekolahModel->save([
            'nama_sekolah' => $this->request->getPost('nama_sekolah'),
            'kode_otorisasi' => $kode_acak
        ]);
        
        session()->setFlashdata('pesan', 'Sekolah baru ditambahkan dengan kode: ' . $kode_acak);
        return redirect()->to('/admin/kelola_sekolah');
    }

    public function refresh_kode_sekolah($id_sekolah)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        
        $sekolahModel = new \App\Models\SekolahModel();
        $kode_baru = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
        
        $sekolahModel->update($id_sekolah, ['kode_otorisasi' => $kode_baru]);
        
        session()->setFlashdata('pesan', 'Kode otorisasi berhasil diperbarui menjadi: ' . $kode_baru);
        return redirect()->to('/admin/kelola_sekolah');
    }

    public function hapus_sekolah($id_sekolah)
    {
        if (session()->get('peran') !== 'admin' && session()->get('peran') !== 'guru') {
    return redirect()->to('/auth');
}
        $sekolahModel = new \App\Models\SekolahModel();
        $sekolahModel->delete($id_sekolah);
        session()->setFlashdata('pesan', 'Data sekolah dihapus!');
        return redirect()->to('/admin/kelola_sekolah');
    }

    // ==========================================
    // CMS KUESIONER DINAMIS
    // ==========================================
    public function kelola_kuesioner()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');

        $db = \Config\Database::connect();
        
        // Ambil daftar kuesioner yang sudah ada untuk ditampilkan di tabel
        $data['daftar_kuesioner'] = $db->query("
            SELECT k.*, COUNT(s.id_soal) as jumlah_soal 
            FROM kuesioner k 
            LEFT JOIN soal_kuesioner s ON k.id_kuesioner = s.id_kuesioner 
            GROUP BY k.id_kuesioner 
            ORDER BY k.dibuat_pada DESC
        ")->getResultArray();

        return view('admin/kelola_kuesioner', $data);
    }

    public function simpan_kuesioner()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');

        $db = \Config\Database::connect();

        // 1. Simpan Data Induk Kuesioner
        $db->table('kuesioner')->insert([
            'judul_kuesioner' => $this->request->getPost('judul_kuesioner'),
            'urutan_tampil' => $this->request->getPost('urutan_tampil'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'status_aktif'    => 1
        ]);
        
        $id_kuesioner = $db->insertID(); // Dapatkan ID kuesioner yang baru saja dibuat

        // 2. Simpan Soal dan Opsi (Array Dinamis ke JSON)
        $soal_array = $this->request->getPost('soal'); 

        if (!empty($soal_array)) {
            $data_soal = [];
            $urutan = 1;
            foreach ($soal_array as $soal) {
                // Pastikan soal tidak kosong dan opsinya ada
                if (!empty($soal['teks']) && !empty($soal['opsi'])) {
                    $data_soal[] = [
                        'id_kuesioner' => $id_kuesioner,
                        'teks_soal'    => $soal['teks'],
                        'opsi_jawaban' => json_encode($soal['opsi']), // Ubah array opsi menjadi format JSON string
                        'urutan'       => $urutan
                    ];
                    $urutan++;
                }
            }
            // Insert Batch (Masukkan banyak data soal sekaligus)
            if (count($data_soal) > 0) {
                $db->table('soal_kuesioner')->insertBatch($data_soal);
            }
        }

        session()->setFlashdata('pesan', 'Kuesioner beserta soal dinamisnya berhasil disimpan!');
        return redirect()->to('/admin/kelola_kuesioner');
    }

    // ==========================================
    // FASE 2: EDIT, HAPUS & LAPORAN KUESIONER
    // ==========================================
    public function hapus_kuesioner($id_kuesioner)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $db->table('kuesioner')->where('id_kuesioner', $id_kuesioner)->delete();
        // Berkat ON DELETE CASCADE di database, soal dan jawaban otomatis terhapus
        session()->setFlashdata('pesan', 'Kuesioner berhasil dihapus secara permanen.');
        return redirect()->to('/admin/kelola_kuesioner');
    }

    public function edit_kuesioner($id_kuesioner)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $data['kuesioner'] = $db->table('kuesioner')->where('id_kuesioner', $id_kuesioner)->get()->getRowArray();
        return view('admin/edit_kuesioner', $data);
    }

    public function update_kuesioner($id_kuesioner)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $db->table('kuesioner')->where('id_kuesioner', $id_kuesioner)->update([
            'judul_kuesioner' => $this->request->getPost('judul_kuesioner'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'urutan_tampil'   => $this->request->getPost('urutan_tampil'),
            'status_aktif'    => $this->request->getPost('status_aktif')
        ]);
        session()->setFlashdata('pesan', 'Pengaturan kuesioner berhasil diperbarui.');
        return redirect()->to('/admin/kelola_kuesioner');
    }

    public function laporan_kuesioner($id_kuesioner)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $data['kuesioner'] = $db->table('kuesioner')->where('id_kuesioner', $id_kuesioner)->get()->getRowArray();

        // Ambil daftar siswa yang sudah mengerjakan kuesioner ini
        $data['partisipan'] = $db->query("
            SELECT pk.id_partisipasi, pk.tanggal_isi, p.nama_lengkap, p.nama_sekolah, p.email
            FROM partisipasi_kuesioner pk
            JOIN pengguna p ON pk.id_pengguna = p.id_pengguna
            WHERE pk.id_kuesioner = ?
            ORDER BY pk.tanggal_isi DESC
        ", [$id_kuesioner])->getResultArray();

        return view('admin/laporan_kuesioner', $data);
    }

    public function detail_jawaban_kuesioner($id_partisipasi)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();

        $data['info'] = $db->query("
            SELECT p.nama_lengkap, k.judul_kuesioner, k.id_kuesioner, pk.tanggal_isi
            FROM partisipasi_kuesioner pk
            JOIN pengguna p ON pk.id_pengguna = p.id_pengguna
            JOIN kuesioner k ON pk.id_kuesioner = k.id_kuesioner
            WHERE pk.id_partisipasi = ?
        ", [$id_partisipasi])->getRowArray();

        // Ambil soal dan jawaban yang dipilih siswa
        $data['jawaban'] = $db->query("
            SELECT sk.teks_soal, jk.jawaban_teks
            FROM jawaban_kuesioner jk
            JOIN soal_kuesioner sk ON jk.id_soal = sk.id_soal
            WHERE jk.id_partisipasi = ?
            ORDER BY sk.urutan ASC
        ", [$id_partisipasi])->getResultArray();

        return view('admin/detail_jawaban_kuesioner', $data);
    }

    // ==========================================
    // FASE 2: LAPORAN MODUL & SIMULASI
    // ==========================================
    public function laporan_modul($id_modul)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $data['modul'] = $db->table('modul_belajar')->where('id_modul', $id_modul)->get()->getRowArray();
        
        // Tarik data siswa yang sudah menyentuh modul ini
        $data['partisipan'] = $db->query("
            SELECT ps.id_progres, ps.tanggal_selesai, ps.skor_kuis, ps.status_modul, p.nama_lengkap, p.nama_sekolah
            FROM progres_siswa ps
            JOIN pengguna p ON ps.id_pengguna = p.id_pengguna
            WHERE ps.id_modul = ?
            ORDER BY ps.tanggal_selesai DESC
        ", [$id_modul])->getResultArray();

        return view('admin/laporan_modul', $data);
    }

    public function detail_jawaban_kuis($id_progres)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        // Ambil profil siswa dan modul terkait
        $progres = $db->query("
            SELECT ps.*, p.nama_lengkap, m.judul_modul 
            FROM progres_siswa ps
            JOIN pengguna p ON ps.id_pengguna = p.id_pengguna
            JOIN modul_belajar m ON ps.id_modul = m.id_modul
            WHERE ps.id_progres = ?
        ", [$id_progres])->getRowArray();
        
        $data['info'] = $progres;
        
        // Bongkar JSON jawaban siswa
        $jawaban_siswa = json_decode($progres['detail_jawaban'], true) ?? [];
        
        // Ambil kunci jawaban asli dari database
        $soal = $db->table('soal_kuis')->where('id_modul', $progres['id_modul'])->get()->getResultArray();
        
        $detail = [];
        foreach($soal as $s) {
            $id_s = $s['id_soal'];
            $jawab = $jawaban_siswa[$id_s] ?? 'Tidak dijawab';
            $detail[] = [
                'pertanyaan' => $s['pertanyaan'],
                'jawaban_benar' => $s['jawaban_benar'],
                'jawaban_siswa' => $jawab,
                'is_benar' => ($jawab === $s['jawaban_benar'])
            ];
        }
        $data['detail_jawaban'] = $detail;

        return view('admin/detail_jawaban_kuis', $data);
    }

    public function laporan_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $data['skenario'] = $db->table('skenario_simulasi')->where('id_skenario', $id_skenario)->get()->getRowArray();
        
        // Tarik data siswa yang memainkan simulasi ini
        $data['partisipan'] = $db->query("
            SELECT rs.*, p.nama_lengkap, p.nama_sekolah
            FROM riwayat_simulasi rs
            JOIN pengguna p ON rs.id_pengguna = p.id_pengguna
            WHERE rs.id_skenario = ?
            ORDER BY rs.tanggal_percobaan DESC
        ", [$id_skenario])->getResultArray();

        return view('admin/laporan_simulasi', $data);
    }

    // ==========================================
    // FASE 2: MANAJEMEN PENGGUNA (SUSPEND)
    // ==========================================
    public function manajemen_pengguna()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        // Tarik semua data siswa dan guru
        $data['daftar_pengguna'] = $db->table('pengguna')
                                      ->whereIn('peran', ['siswa', 'guru'])
                                      ->orderBy('peran', 'ASC') // Urutkan Guru di atas, Siswa di bawah
                                      ->orderBy('nama_lengkap', 'ASC')
                                      ->get()->getResultArray();
                                      
        return view('admin/manajemen_pengguna', $data);
    }

    public function toggle_status_pengguna($id_pengguna)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        // Cari pengguna berdasarkan ID
        $user = $db->table('pengguna')->where('id_pengguna', $id_pengguna)->get()->getRowArray();
        
        if($user) {
            // Jika status 1 (aktif), ubah jadi 0 (suspend). Jika 0, ubah jadi 1.
            $status_baru = $user['status_aktif'] == 1 ? 0 : 1;
            
            $db->table('pengguna')->where('id_pengguna', $id_pengguna)->update(['status_aktif' => $status_baru]);
            
            $pesan = $status_baru == 1 
                ? "✅ Akun {$user['nama_lengkap']} berhasil diaktifkan kembali." 
                : "🚫 Akun {$user['nama_lengkap']} berhasil ditangguhkan (suspend).";
                
            session()->setFlashdata('pesan', $pesan);
        }
        
        return redirect()->to('/admin/manajemen_pengguna');
    }

    // ==========================================
    // FASE 3: KELOLA TIPS HARIAN / MOTIVASI
    // ==========================================
    public function kelola_tips()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $data['daftar_tips'] = $db->table('tips_harian')->orderBy('dibuat_pada', 'DESC')->get()->getResultArray();
        return view('admin/kelola_tips', $data);
    }

    public function simpan_tips()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $db->table('tips_harian')->insert([
            'isi_tips' => $this->request->getPost('isi_tips')
        ]);
        
        session()->setFlashdata('pesan', 'Tips harian baru berhasil ditambahkan!');
        return redirect()->to('/admin/kelola_tips');
    }

    public function hapus_tips($id_tips)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $db->table('tips_harian')->where('id_tips', $id_tips)->delete();
        
        session()->setFlashdata('pesan', 'Tips berhasil dihapus.');
        return redirect()->to('/admin/kelola_tips');
    }

    // ==========================================
    // FASE 3: EKSPOR DATA RISET (ANONIM)
    // ==========================================
    public function ekspor_riset()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        return view('admin/ekspor_riset');
    }

 // ===================================================================
    // DATA RISET TRANSPARAN DAN INTEGRASI MULTI-FORMAT UNTUK ADMIN
    // ===================================================================
    public function unduh_data($kategori, $format)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $filename = "CyberGuard_MasterData_{$kategori}_" . date('Y-m-d');

        // Mengambil berkas data asli tanpa modifikasi anonimitas hash
        if ($kategori === 'modul') {
            $headers = ['ID Pengguna', 'Nama Lengkap', 'Sekolah', 'ID Modul', 'Status', 'Skor Kuis', 'Tanggal Selesai'];
            $data = $db->query("SELECT p.id_pengguna, p.nama_lengkap, p.nama_sekolah, ps.id_modul, ps.status_modul, ps.skor_kuis, ps.tanggal_selesai FROM progres_siswa ps JOIN pengguna p ON ps.id_pengguna = p.id_pengguna WHERE p.peran = 'siswa'")->getResultArray();
        } elseif ($kategori === 'simulasi') {
            $headers = ['ID Pengguna', 'Nama Lengkap', 'Sekolah', 'ID Skenario', 'Skor Kontrol Diri', 'Tanggal Percobaan'];
            $data = $db->query("SELECT p.id_pengguna, p.nama_lengkap, p.nama_sekolah, rs.id_skenario, rs.skor_kontrol_diri, rs.tanggal_percobaan FROM riwayat_simulasi rs JOIN pengguna p ON rs.id_pengguna = p.id_pengguna WHERE p.peran = 'siswa'")->getResultArray();
        } else {
            $headers = ['ID Pengguna', 'Nama Lengkap', 'Sekolah', 'ID Kuesioner', 'ID Soal', 'Jawaban', 'Tanggal Isi'];
            $data = $db->query("SELECT p.id_pengguna, p.nama_lengkap, p.nama_sekolah, pk.id_kuesioner, jk.id_soal, jk.jawaban_teks, pk.tanggal_isi FROM jawaban_kuesioner jk JOIN partisipasi_kuesioner pk ON jk.id_partisipasi = pk.id_partisipasi JOIN pengguna p ON pk.id_pengguna = p.id_pengguna WHERE p.peran = 'siswa'")->getResultArray();
        }

        if (empty($data)) {
            exit("Belum ada rekaman data di dalam sistem untuk kategori ini.");
        }

        // EKSPOR FORMAT CSV
        if ($format === 'csv') {
            header("Content-Disposition: attachment; filename=$filename.csv");
            header("Content-Type: text/csv; charset=UTF-8");
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $headers);
            foreach ($data as $row) fputcsv($file, $row);
            fclose($file); exit;
        } 
        
        // EKSPOR FORMAT EXCEL (HTML TABLE NATIVE STRUCTURE)
        if ($format === 'excel') {
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=$filename.xls");
            echo "<table border='1'><tr style='background:#f4f4f4;'>";
            foreach ($headers as $h) echo "<th>$h</th>";
            echo "</tr>";
            foreach ($data as $row) {
                echo "<tr>";
                foreach ($row as $v) echo "<td>$v</td>";
                echo "</tr>";
            }
            echo "</table>"; exit;
        }

        // EKSPOR FORMAT PDF VIA LAYOUT CETAK BROWSER NATIVE
        if ($format === 'pdf') {
            return view('guru/laporan_cetak_pdf', ['data' => $data]);
        }
    }

    // ==========================================
    // CMS KELOLA PANDUAN GURU/FASILITATOR
    // ==========================================
    public function kelola_panduan()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $data['daftar_panduan'] = $db->table('panduan_guru')->orderBy('kode_panduan', 'ASC')->get()->getResultArray();
        return view('admin/kelola_panduan', $data);
    }

    public function simpan_panduan()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();

        $tipe_media = $this->request->getPost('tipe_media');
        $url_youtube = $this->request->getPost('url_youtube');
        $file_media = null;

        // Mesin Pengunggah File (Hanya jika tipe medianya butuh file)
        if (in_array($tipe_media, ['gambar', 'dokumen', 'audio'])) {
            $file = $this->request->getFile('file_media');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                // Simpan file ke dalam public/uploads/panduan/
                $file->move('uploads/panduan/', $newName);
                $file_media = $newName;
            }
        }

        $db->table('panduan_guru')->insert([
            'kode_panduan'   => $this->request->getPost('kode_panduan'),
            'judul_panduan'  => $this->request->getPost('judul_panduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'konten_panduan' => $this->request->getPost('konten_panduan'),
            'tipe_media'     => $tipe_media,
            'file_media'     => $file_media,
            'url_youtube'    => $url_youtube
        ]);

        session()->setFlashdata('pesan', 'Materi panduan interaktif berhasil diterbitkan untuk Guru BK.');
        return redirect()->to('/admin/kelola_panduan');
    }

    public function edit_panduan($id_panduan)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $data['panduan'] = $db->table('panduan_guru')->where('id_panduan', $id_panduan)->get()->getRowArray();
        return view('admin/edit_panduan', $data);
    }

    public function update_panduan()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();

        $id_panduan  = $this->request->getPost('id_panduan');
        $tipe_media  = $this->request->getPost('tipe_media');
        $url_youtube = $this->request->getPost('url_youtube');
        $file_media  = $this->request->getPost('file_lama'); // Gunakan file lama sebagai default
        
        // Cek jika Admin mengunggah file media baru
        if (in_array($tipe_media, ['gambar', 'dokumen', 'audio'])) {
            $file = $this->request->getFile('file_media');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/panduan/', $newName);
                $file_media = $newName; // Timpa nama file lama dengan yang baru
            }
        }

        $db->table('panduan_guru')->where('id_panduan', $id_panduan)->update([
            'kode_panduan'   => $this->request->getPost('kode_panduan'),
            'judul_panduan'  => $this->request->getPost('judul_panduan'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'konten_panduan' => $this->request->getPost('konten_panduan'),
            'tipe_media'     => $tipe_media,
            'file_media'     => $file_media,
            'url_youtube'    => $url_youtube
        ]);

        session()->setFlashdata('pesan', 'Materi panduan berhasil diperbarui!');
        return redirect()->to('/admin/kelola_panduan');
    }

    public function hapus_panduan($id_panduan)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $db->table('panduan_guru')->where('id_panduan', $id_panduan)->delete();
        
        session()->setFlashdata('pesan', 'Materi panduan berhasil dihapus.');
        return redirect()->to('/admin/kelola_panduan');
    }

    // ==========================================
    // MODERASI JADWAL INTERVENSI GURU BK BY ADMIN
    // ==========================================
    public function kelola_intervensi()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $data['jadwal'] = $db->query("
            SELECT jk.*, psis.nama_lengkap as nama_siswa, psis.nama_sekolah, pguru.nama_lengkap as nama_guru
            FROM jadwal_konseling jk
            JOIN pengguna psis ON jk.id_siswa = psis.id_pengguna
            JOIN pengguna pguru ON jk.id_guru = pguru.id_pengguna
            ORDER BY jk.tanggal_konseling DESC
        ")->getResultArray();
        
        return view('admin/kelola_intervensi', $data);
    }

    public function update_intervensi()
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $id_jadwal = $this->request->getPost('id_jadwal');
        $db->table('jadwal_konseling')->where('id_jadwal', $id_jadwal)->update([
            'tanggal_konseling' => $this->request->getPost('tanggal_konseling'),
            'catatan' => $this->request->getPost('catatan')
        ]);
        
        session()->setFlashdata('pesan', 'Jadwal intervensi berhasil disesuaikan oleh Admin.');
        return redirect()->to('/admin/kelola_intervensi');
    }

    public function batal_intervensi($id_jadwal)
    {
        if (session()->get('peran') !== 'admin') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        
        $db->table('jadwal_konseling')->where('id_jadwal', $id_jadwal)->update(['status' => 'dibatalkan']);
        session()->setFlashdata('pesan', 'Jadwal konseling berhasil dibatalkan oleh Admin.');
        return redirect()->to('/admin/kelola_intervensi');
    }
}