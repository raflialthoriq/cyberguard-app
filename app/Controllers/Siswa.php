<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogSuasanaHatiModel;
use App\Models\ModulBelajarModel;
use App\Models\SoalKuisModel;
use App\Models\ProgresSiswaModel;
use App\Models\SkenarioSimulasiModel;
use App\Models\OpsiSimulasiModel;
use App\Models\RiwayatSimulasiModel;

class Siswa extends BaseController
{
    // ==========================================
    // FUNGSI PENJAGA RUTE KETAT (STRICT LOCKING)
    // ==========================================
    private function _dapatkan_status_item($tipe_target, $id_target)
    {
        $db = \Config\Database::connect();
        $id_pengguna = session()->get('id_pengguna');

        // Ambil Modul dan Kuesioner beserta status pengerjaannya
        $modul = $db->query("SELECT id_modul as id, urutan_modul as urutan, 'modul' as tipe, (SELECT status_modul FROM progres_siswa WHERE id_modul = modul_belajar.id_modul AND id_pengguna = ?) as status_modul FROM modul_belajar", [$id_pengguna])->getResultArray();

        $kuesioner = $db->query("SELECT id_kuesioner as id, urutan_tampil as urutan, 'kuesioner' as tipe, (SELECT id_partisipasi FROM partisipasi_kuesioner WHERE id_kuesioner = kuesioner.id_kuesioner AND id_pengguna = ?) as id_partisipasi FROM kuesioner WHERE status_aktif = 1", [$id_pengguna])->getResultArray();

        // Gabungkan dan urutkan
        $semua_item = array_merge($modul, $kuesioner);
        usort($semua_item, function ($a, $b) {
            return $a['urutan'] <=> $b['urutan'];
        });

        $buka_berikutnya = true;
        foreach ($semua_item as $item) {
            $is_selesai = false;

            if ($item['tipe'] === 'modul' && $item['status_modul'] === 'selesai') $is_selesai = true;
            if ($item['tipe'] === 'kuesioner' && !empty($item['id_partisipasi'])) $is_selesai = true;

            $status_aktual = 'terkunci';
            if ($is_selesai) {
                $status_aktual = 'selesai';
                $buka_berikutnya = true;
            } elseif ($buka_berikutnya) {
                $status_aktual = 'aktif';
                $buka_berikutnya = false;
            }

            if ($item['tipe'] === $tipe_target && $item['id'] == $id_target) {
                return $status_aktual;
            }
        }
        return 'terkunci';
    }

    // ==========================================
    // FITUR BERANDA & JURNAL
    // ==========================================
    public function beranda()
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        $db = \Config\Database::connect();
        $id_pengguna = session()->get('id_pengguna');

        // LOGIKA OTOMATISASI H+1: Ubah status jadwal menjadi 'selesai' jika sudah lewat 1 hari
        $db->query("UPDATE jadwal_konseling SET status = 'selesai' WHERE id_siswa = ? AND tanggal_konseling < DATE_SUB(NOW(), INTERVAL 1 DAY)", [$id_pengguna]);

        $modulModel = new \App\Models\ModulBelajarModel();
        $progresModel = new \App\Models\ProgresSiswaModel();
        $jurnalModel = new \App\Models\LogSuasanaHatiModel();

        // Ambil data user untuk Poin dan Streak
        $user_data = $db->table('pengguna')->where('id_pengguna', $id_pengguna)->get()->getRowArray();

        $total_modul = $modulModel->countAllResults();
        $modul_selesai = $progresModel->where('id_pengguna', $id_pengguna)->where('status_modul', 'selesai')->countAllResults();
        $persentase = ($total_modul > 0) ? round(($modul_selesai / $total_modul) * 100) : 0;

        $jurnal_hari_ini = $jurnalModel->where('id_pengguna', $id_pengguna)->where('tanggal_jurnal', date('Y-m-d'))->first();
        $sudah_isi_mood = ($jurnal_hari_ini !== null);

        $baru_saja_isi_mood = session()->getFlashdata('mood_tersimpan') ? true : false;

        // Tips sudah otomatis acak berkat ORDER BY RAND()
        $random_tips = $db->query("SELECT isi_tips FROM tips_harian ORDER BY RAND() LIMIT 1")->getRowArray();
        $tips_harian = $random_tips ? $random_tips['isi_tips'] : "Tetap semangat belajar dan jaga kesehatan mentalmu hari ini!";

        $data = [
            'nama_panggilan' => session()->get('nama_panggilan'),
            'modul_selesai'  => $modul_selesai,
            'total_modul'    => $total_modul,
            'persentase'     => $persentase,
            'tips_harian'    => $tips_harian,
            'sudah_isi_mood' => $sudah_isi_mood,
            'baru_saja_isi_mood' => $baru_saja_isi_mood,
            'streak_login'   => $user_data['streak_login'] ?? 0,
            'total_poin'     => $user_data['total_poin'] ?? 0,
            // Tambahkan baris di bawah ini untuk mengambil path foto profil
            'url_avatar'     => $user_data['url_avatar']
        ];

        return view('siswa/beranda', $data);
    }

    public function jurnal()
    {
        $jurnalModel = new LogSuasanaHatiModel();
        $encrypter = \Config\Services::encrypter();
        $id_pengguna = session()->get('id_pengguna');

        // Menangkap opsi limit dari dropdown (Default: 5 data jika belum dipilih)
        $limit = $this->request->getGet('limit') ?? 5;

        // Inisialisasi query dasar
        $query = $jurnalModel->where('id_pengguna', $id_pengguna)
            ->orderBy('tanggal_jurnal', 'DESC');

        // Jika opsi yang dipilih bukan 'semua', berikan batasan query
        if ($limit !== 'semua') {
            $query->limit((int)$limit);
        }

        $riwayat_jurnal = $query->findAll();

        // Proses dekripsi teks jurnal
        foreach ($riwayat_jurnal as &$jurnal) {
            try {
                $jurnal['teks_jurnal'] = $encrypter->decrypt(base64_decode($jurnal['teks_jurnal']));
            } catch (\Exception $e) {
                // Safe handling jika terdapat text lama yang tidak terenkripsi
            }
        }

        $data = [
            'title'          => 'Jurnal Harian',
            'riwayat_jurnal' => $riwayat_jurnal,
            'current_limit'  => $limit // Dikirim ke view untuk mempertahankan posisi select terpilih
        ];

        return view('siswa/jurnal', $data);
    }

    public function simpan_jurnal()
    {
        $jurnalModel = new LogSuasanaHatiModel();
        $encrypter = \Config\Services::encrypter();

        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');
        $teks_asli = $this->request->getPost('teks_jurnal');

        $suasana_hati = $this->request->getPost('suasana_hati');
        $teks_mentah = $this->request->getPost('teks_jurnal');

        $teks_enkripsi = base64_encode($encrypter->encrypt($teks_mentah));

        // Gunakan backslash (\) di awal untuk langsung memanggil library CI4
        $waktu_sekarang = \CodeIgniter\I18n\Time::now('Asia/Jakarta', 'id_ID');

        $data = [
            'id_pengguna'    => session()->get('id_pengguna'),
            'teks_jurnal'    => $teks_enkripsi,
            'suasana_hati'   => empty($suasana_hati) ? null : $suasana_hati,
            'tanggal_jurnal' => $waktu_sekarang->toDateTimeString()
        ];

        session()->setFlashdata('pesan', 'Jurnal dan suasana hatimu berhasil disimpan secara rahasia!');
        session()->setFlashdata('mood_tersimpan', true);

        $jurnalModel->insert($data);
        return redirect()->to(base_url('siswa/beranda'))->with('success', 'Catatan harianmu berhasil disimpan dengan aman.');
    }

    // ==========================================
    // FITUR MODUL & KUESIONER TERINTEGRASI
    // ==========================================
    public function daftar_modul()
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        $db = \Config\Database::connect();
        $id_pengguna = session()->get('id_pengguna');

        $modul = $db->query("SELECT id_modul as id, judul_modul as judul, konten_materi, urutan_modul as urutan, 'modul' as tipe, (SELECT status_modul FROM progres_siswa WHERE id_modul = modul_belajar.id_modul AND id_pengguna = ?) as status_modul FROM modul_belajar", [$id_pengguna])->getResultArray();

        $kuesioner = $db->query("SELECT id_kuesioner as id, judul_kuesioner as judul, deskripsi, urutan_tampil as urutan, 'kuesioner' as tipe, (SELECT id_partisipasi FROM partisipasi_kuesioner WHERE id_kuesioner = kuesioner.id_kuesioner AND id_pengguna = ?) as id_partisipasi FROM kuesioner WHERE status_aktif = 1", [$id_pengguna])->getResultArray();

        $semua_item = array_merge($modul, $kuesioner);
        usort($semua_item, function ($a, $b) {
            return $a['urutan'] <=> $b['urutan'];
        });

        $buka_berikutnya = true;
        $daftar_final = [];

        foreach ($semua_item as $item) {
            $is_selesai = false;
            if ($item['tipe'] === 'modul' && $item['status_modul'] === 'selesai') $is_selesai = true;
            if ($item['tipe'] === 'kuesioner' && !empty($item['id_partisipasi'])) $is_selesai = true;

            $status_aktual = 'terkunci';
            if ($is_selesai) {
                $status_aktual = 'selesai';
                $buka_berikutnya = true;
            } elseif ($buka_berikutnya) {
                $status_aktual = 'aktif';
                $buka_berikutnya = false;
            }

            // Ekstrak deskripsi dinamis (karena tabel modul_belajar tidak punya kolom deskripsi)
            $deskripsi_teks = '';
            if ($item['tipe'] === 'modul') {
                $teks_bersih = strip_tags($item['konten_materi']); // Hapus tag HTML
                $deskripsi_teks = (strlen($teks_bersih) > 60) ? substr($teks_bersih, 0, 60) . '...' : $teks_bersih;
            } else {
                $deskripsi_teks = $item['deskripsi'];
            }

            $daftar_final[] = [
                'id' => $item['id'],
                'judul' => $item['judul'],
                'deskripsi' => $deskripsi_teks,
                'urutan' => $item['urutan'],
                'tipe' => $item['tipe'],
                'status' => $status_aktual
            ];
        }

        return view('siswa/daftar_modul', ['daftar_item' => $daftar_final]);
    }

    // ------------------------------------------
    // FUNGSI BARU: RENDER & SIMPAN KUESIONER
    // ------------------------------------------
    public function isi_kuesioner($id_kuesioner)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        // HADANG JIKA TERKUNCI
        if ($this->_dapatkan_status_item('kuesioner', $id_kuesioner) === 'terkunci') {
            session()->setFlashdata('pesan_gagal', 'Kuesioner ini masih terkunci! Selesaikan materi/kuis di atasnya terlebih dahulu.');
            return redirect()->to('/siswa/modul');
        }

        $db = \Config\Database::connect();
        $data['kuesioner'] = $db->table('kuesioner')->where('id_kuesioner', $id_kuesioner)->get()->getRowArray();
        if (!$data['kuesioner']) return redirect()->to('/siswa/modul');

        $data['soal_kuesioner'] = $db->table('soal_kuesioner')->where('id_kuesioner', $id_kuesioner)->orderBy('urutan', 'ASC')->get()->getResultArray();
        return view('siswa/isi_kuesioner', $data);
    }

    public function simpan_jawaban_kuesioner()
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        $db = \Config\Database::connect();

        $id_kuesioner = $this->request->getPost('id_kuesioner');
        $jawaban = $this->request->getPost('jawaban'); // Bentuk array: [id_soal => jawaban_teks]
        $id_pengguna = session()->get('id_pengguna');

        // 1. Simpan Partisipasi Siswa
        $db->table('partisipasi_kuesioner')->insert([
            'id_pengguna' => $id_pengguna,
            'id_kuesioner' => $id_kuesioner,
            'tanggal_isi' => date('Y-m-d H:i:s')
        ]);
        $id_partisipasi = $db->insertID(); // Ambil ID Partisipasi yang baru dibuat

        // 2. Simpan Detail Jawaban
        if (!empty($jawaban)) {
            $data_jawaban = [];
            foreach ($jawaban as $id_soal => $teks_jawaban) {
                $data_jawaban[] = [
                    'id_partisipasi' => $id_partisipasi,
                    'id_soal' => $id_soal,
                    'jawaban_teks' => $teks_jawaban
                ];
            }
            if (count($data_jawaban) > 0) {
                $db->table('jawaban_kuesioner')->insertBatch($data_jawaban);
            }
        }

        session()->setFlashdata('pesan', 'Kuesioner berhasil diselesaikan! Terima kasih atas partisipasimu.');
        return redirect()->to('/siswa/modul');
    }

    // ==========================================
    // FITUR BACA & KUIS MODUL
    // ==========================================
    public function baca_modul($id_modul)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        // HADANG JIKA TERKUNCI
        if ($this->_dapatkan_status_item('modul', $id_modul) === 'terkunci') {
            session()->setFlashdata('pesan_gagal', 'Modul masih terkunci! Selesaikan materi/kuesioner di atasnya terlebih dahulu.');
            return redirect()->to('/siswa/modul');
        }

        $modulModel = new \App\Models\ModulBelajarModel();
        $modul = $modulModel->find($id_modul);
        if (!$modul) return redirect()->to('/siswa/modul');

        $youtube_id = '';
        if ($modul['tipe_media'] === 'youtube' && !empty($modul['url_youtube'])) {
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $modul['url_youtube'], $match);
            $youtube_id = isset($match[1]) ? $match[1] : '';
        }

        return view('siswa/baca_modul', ['modul' => $modul, 'youtube_id' => $youtube_id]);
    }

    public function kuis_modul($id_modul)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        // HADANG JIKA TERKUNCI
        if ($this->_dapatkan_status_item('modul', $id_modul) === 'terkunci') {
            session()->setFlashdata('pesan_gagal', 'Kuis masih terkunci! Selesaikan materi di atasnya terlebih dahulu.');
            return redirect()->to('/siswa/modul');
        }

        $modulModel = new \App\Models\ModulBelajarModel();
        $soalModel = new \App\Models\SoalKuisModel();
        $progresModel = new \App\Models\ProgresSiswaModel();

        $data['modul'] = $modulModel->find($id_modul);
        $data['daftar_soal'] = $soalModel->where('id_modul', $id_modul)->findAll();
        $progres = $progresModel->where('id_pengguna', session()->get('id_pengguna'))->where('id_modul', $id_modul)->first();

        $data['is_remedial'] = $this->request->getGet('remedial') == '1';
        $data['progres'] = $progres;
        $data['jawaban_tersimpan'] = ($progres && !empty($progres['detail_jawaban'])) ? json_decode($progres['detail_jawaban'], true) : [];

        return view('siswa/kuis_modul', $data);
    }

    public function proses_kuis($id_modul)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');

        $soalModel = new \App\Models\SoalKuisModel();
        $progresModel = new \App\Models\ProgresSiswaModel();

        $daftar_soal = $soalModel->where('id_modul', $id_modul)->findAll();
        $id_pengguna = session()->get('id_pengguna');
        $jumlah_soal = count($daftar_soal);

        if ($jumlah_soal == 0) return redirect()->to('/siswa/modul');

        $jawaban_benar = 0;
        $jawaban_user_array = [];

        foreach ($daftar_soal as $soal) {
            $jawaban_user = $this->request->getPost('soal_' . $soal['id_soal']);
            $jawaban_user_array[$soal['id_soal']] = $jawaban_user;

            if ($jawaban_user === $soal['jawaban_benar']) {
                $jawaban_benar++;
            }
        }

        $skor_akhir = round(($jawaban_benar / $jumlah_soal) * 100);
        $status_baru = ($skor_akhir >= 70) ? 'selesai' : 'aktif';

        $data_simpan = [
            'status_modul' => $status_baru,
            'skor_kuis' => $skor_akhir,
            'detail_jawaban' => json_encode($jawaban_user_array),
            'tanggal_selesai' => date('Y-m-d H:i:s')
        ];

        $progres_sebelumnya = $progresModel->where('id_pengguna', $id_pengguna)->where('id_modul', $id_modul)->first();

        if ($progres_sebelumnya) {
            $progresModel->update($progres_sebelumnya['id_progres'], $data_simpan);
        } else {
            $data_simpan['id_pengguna'] = $id_pengguna;
            $data_simpan['id_modul'] = $id_modul;
            $progresModel->save($data_simpan);
        }

        if ($skor_akhir >= 70) {
            // LOGIKA TAMBAH POIN GAMIFIKASI (Hanya dieksekusi saat LULUS)
            if (!$progres_sebelumnya || $progres_sebelumnya['status_modul'] !== 'selesai') {
                $db = \Config\Database::connect();
                $db->query("UPDATE pengguna SET total_poin = total_poin + 5 WHERE id_pengguna = ?", [$id_pengguna]);
            }
            session()->setFlashdata('pesan_sukses', 'Selamat! Kamu LULUS dengan skor ' . $skor_akhir . '%. Modul berikutnya telah terbuka!');
        } else {
            session()->setFlashdata('pesan_gagal', 'Skor kamu ' . $skor_akhir . '%. Butuh 70% untuk lulus. Cek jawaban merahmu dan perbaiki di mode Remedial!');
        }

        return redirect()->to('/siswa/modul/kuis/' . $id_modul);
    }

    // ==========================================
    // FITUR SIMULASI CBT
    // ==========================================
    public function simulasi()
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $id_pengguna = session()->get('id_pengguna');

        $simulasiModel = new SkenarioSimulasiModel();
        $daftar_simulasi = $simulasiModel->findAll();

        // Cek status tiap simulasi berdasarkan riwayat kelulusan (Skor > 0)
        foreach ($daftar_simulasi as &$sim) {
            $riwayat = $db->table('riwayat_simulasi')
                ->where('id_pengguna', $id_pengguna)
                ->where('id_skenario', $sim['id_skenario'])
                ->where('skor_kontrol_diri >', 0) // Syarat lulus ambang nilai
                ->orderBy('tanggal_percobaan', 'DESC')
                ->get()->getRowArray();

            $sim['status'] = $riwayat ? 'selesai' : 'belum';
        }

        return view('siswa/daftar_simulasi', ['daftar_simulasi' => $daftar_simulasi]);
    }

    public function main_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');
        $db = \Config\Database::connect();
        $id_pengguna = session()->get('id_pengguna');

        $simulasiModel = new SkenarioSimulasiModel();
        $opsiModel = new OpsiSimulasiModel();

        $data['skenario'] = $simulasiModel->find($id_skenario);
        $data['daftar_opsi'] = $opsiModel->where('id_skenario', $id_skenario)->findAll();

        // Cek apakah siswa sudah punya riwayat lulus di skenario ini
        $riwayat_terbaik = $db->table('riwayat_simulasi')
            ->where('id_pengguna', $id_pengguna)
            ->where('id_skenario', $id_skenario)
            ->where('skor_kontrol_diri >', 0)
            ->orderBy('tanggal_percobaan', 'DESC')
            ->get()->getRowArray();

        $data['is_review'] = false;

        // Jika sudah lulus, aktifkan Mode Ulasan
        if ($riwayat_terbaik) {
            $data['is_review'] = true;
            $data['riwayat'] = $riwayat_terbaik;

            if (!empty($riwayat_terbaik['id_opsi_terpilih'])) {
                $data['opsi_terpilih'] = $opsiModel->find($riwayat_terbaik['id_opsi_terpilih']);
            }

            // Ambil jawaban dengan skor mutlak tertinggi (Jawaban ideal)
            $data['opsi_terbaik'] = $db->table('opsi_simulasi')
                ->where('id_skenario', $id_skenario)
                ->orderBy('skor_opsi', 'DESC')
                ->get()->getRowArray();
        }

        return view('siswa/main_simulasi', $data);
    }

    public function proses_simulasi($id_skenario)
    {
        if (session()->get('peran') !== 'siswa') return redirect()->to('/auth');
        $opsiModel = new OpsiSimulasiModel();
        $riwayatModel = new RiwayatSimulasiModel();

        $id_opsi_terpilih = $this->request->getPost('pilihan_opsi');
        $opsi_terpilih = $opsiModel->find($id_opsi_terpilih);

        if ($opsi_terpilih) {
            $skor = $opsi_terpilih['skor_opsi'];
            $riwayatModel->save([
                'id_pengguna' => session()->get('id_pengguna'),
                'id_skenario' => $id_skenario,
                'id_opsi_terpilih' => $id_opsi_terpilih, // Simpan memori pilihan
                'skor_kontrol_diri' => $skor,
                'tanggal_percobaan' => date('Y-m-d H:i:s')
            ]);

            if ($skor > 0) {
                $db = \Config\Database::connect();
                $db->query("UPDATE pengguna SET total_poin = total_poin + 10 WHERE id_pengguna = ?", [session()->get('id_pengguna')]);
                session()->setFlashdata('pesan_sukses', "Skor CBT +$skor! Simulasi berhasil diselesaikan.");
            } else {
                session()->setFlashdata('pesan_gagal', "Respons kurang tepat. Silakan coba lagi strategi lain.");
            }
        }

        // PERUBAHAN DISINI: 
        // Menggunakan redirect()->back() agar siswa dikembalikan ke halaman main_simulasi
        // Flashdata (Pop Up Notifikasi) akan otomatis muncul di halaman tersebut.
        return redirect()->back();
    }
}
