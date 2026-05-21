<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login_proses', 'Auth::login_proses');

// Rute Pendaftaran
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register_proses/siswa', 'Auth::register_proses/siswa');
$routes->get('/auth/register_guru', 'Auth::register_guru');
$routes->post('/auth/register_proses/guru', 'Auth::register_proses/guru');
$routes->get('/auth/verifikasi/(:segment)', 'Auth::verifikasi/$1');

// Rute Lupa Password
$routes->get('/auth/lupa_password', 'Auth::lupa_password');
$routes->post('/auth/proses_lupa_password', 'Auth::proses_lupa_password');
$routes->get('/auth/reset_password/(:segment)', 'Auth::reset_password/$1');
$routes->post('/auth/proses_ganti_password', 'Auth::proses_ganti_password');

$routes->get('/auth/logout', 'Auth::logout');

// Rute Dashboard / Beranda Admin
$routes->get('/admin/beranda', 'Admin::beranda');

// Rute Pemantauan Jurnal CBT Siswa
$routes->get('/admin/kelola_jurnal', 'Admin::kelola_jurnal');

// Rute Admin (CMS Manajemen Konten)
$routes->get('/admin/kelola_modul', 'Admin::kelola_modul');
$routes->get('/admin/tambah_modul', 'Admin::tambah_modul');
$routes->post('/admin/simpan_modul', 'Admin::simpan_modul');
$routes->get('/admin/dashboard', 'Admin::kelola_modul');
$routes->get('/admin/ekspor_riset', 'Admin::ekspor_riset');

// CRUD Modul (Lanjutan: Edit & Delete)
$routes->get('/admin/edit_modul/(:num)', 'Admin::edit_modul/$1');
$routes->post('/admin/update_modul/(:num)', 'Admin::update_modul/$1');
$routes->get('/admin/hapus_modul/(:num)', 'Admin::hapus_modul/$1');

// CRUD Skenario Simulasi Interaktif
$routes->get('/admin/kelola_simulasi', 'Admin::kelola_simulasi');
$routes->get('/admin/tambah_simulasi', 'Admin::tambah_simulasi');
$routes->post('/admin/simpan_simulasi', 'Admin::simpan_simulasi');
$routes->get('/admin/edit_simulasi/(:num)', 'Admin::edit_simulasi/$1');
$routes->post('/admin/update_simulasi/(:num)', 'Admin::update_simulasi/$1');
$routes->get('/admin/hapus_simulasi/(:num)', 'Admin::hapus_simulasi/$1');

// CRUD Soal Kuis untuk Modul
$routes->get('/admin/kelola_kuis/(:num)', 'Admin::kelola_kuis/$1');
$routes->post('/admin/simpan_kuis/(:num)', 'Admin::simpan_kuis/$1');
$routes->get('/admin/hapus_kuis/(:num)', 'Admin::hapus_kuis/$1');

// Manajemen Sekolah
$routes->get('/admin/kelola_sekolah', 'Admin::kelola_sekolah');
$routes->post('/admin/simpan_sekolah', 'Admin::simpan_sekolah');
$routes->get('/admin/hapus_sekolah/(:num)', 'Admin::hapus_sekolah/$1');
$routes->get('/admin/refresh_kode_sekolah/(:num)', 'Admin::refresh_kode_sekolah/$1');

$routes->get('/admin/kelola_kuesioner', 'Admin::kelola_kuesioner');
$routes->post('/admin/simpan_kuesioner', 'Admin::simpan_kuesioner');

// ==========================================
// RUTE ADMIN - FASE 2 (MANAJEMEN & LAPORAN)
// ==========================================
$routes->get('/admin/hapus_kuesioner/(:num)', 'Admin::hapus_kuesioner/$1');
$routes->get('/admin/edit_kuesioner/(:num)', 'Admin::edit_kuesioner/$1');
$routes->post('/admin/update_kuesioner/(:num)', 'Admin::update_kuesioner/$1');
$routes->get('/admin/laporan_kuesioner/(:num)', 'Admin::laporan_kuesioner/$1');
$routes->get('/admin/detail_jawaban_kuesioner/(:num)', 'Admin::detail_jawaban_kuesioner/$1');

// ==========================================
// RUTE ADMIN - LAPORAN MODUL & SIMULASI
// ==========================================
$routes->get('/admin/laporan_modul/(:num)', 'Admin::laporan_modul/$1');
$routes->get('/admin/detail_jawaban_kuis/(:num)', 'Admin::detail_jawaban_kuis/$1');
$routes->get('/admin/laporan_simulasi/(:num)', 'Admin::laporan_simulasi/$1');

// ==========================================
// RUTE ADMIN - MANAJEMEN PENGGUNA (SUSPEND)
// ==========================================
$routes->get('/admin/manajemen_pengguna', 'Admin::manajemen_pengguna');
$routes->get('/admin/toggle_status_pengguna/(:num)', 'Admin::toggle_status_pengguna/$1');

// ==========================================
// RUTE ADMIN - KELOLA TIPS HARIAN
// ==========================================
$routes->get('/admin/kelola_tips', 'Admin::kelola_tips');
$routes->post('/admin/simpan_tips', 'Admin::simpan_tips');
$routes->get('/admin/hapus_tips/(:num)', 'Admin::hapus_tips/$1');

// ==========================================
// RUTE GURU BK (Pemantauan CBT Siswa)
// ==========================================
$routes->get('/guru/beranda', 'Guru::beranda');
$routes->get('/guru/kelola_jurnal', 'Guru::kelola_jurnal'); // Pindahkan fitur jurnal AES ke Guru
$routes->get('/guru/manajemen_kelas', 'Guru::manajemen_kelas');
$routes->get('/guru/intervensi_dini', 'Guru::intervensi_dini');
$routes->get('/guru/panduan_fasilitator', 'Guru::panduan_fasilitator');
$routes->get('/guru/laporan_cepat', 'Guru::laporan_cepat');
$routes->post('/guru/simpan_kelas', 'Guru::simpan_kelas');

// Rute Siswa (Nanti akan kita tambahkan Filters/Middleware untuk keamanan)
$routes->get('/siswa/beranda', 'Siswa::beranda');
$routes->post('/siswa/jurnal/simpan', 'Siswa::simpan_jurnal');
$routes->get('/siswa/jurnal', 'Siswa::jurnal');
$routes->get('/siswa/modul', 'Siswa::daftar_modul');
$routes->get('/siswa/modul/baca/(:num)', 'Siswa::baca_modul/$1');
$routes->get('/siswa/modul/kuis/(:num)', 'Siswa::kuis_modul/$1');
$routes->post('/siswa/modul/proses_kuis/(:num)', 'Siswa::proses_kuis/$1');
$routes->get('/siswa/simulasi', 'Siswa::simulasi');
$routes->get('/siswa/simulasi/main/(:num)', 'Siswa::main_simulasi/$1');
$routes->post('/siswa/simulasi/proses/(:num)', 'Siswa::proses_simulasi/$1');

// ==========================================
// RUTE DINAMIS UNTUK MODUL DAN KUESIONER
// ==========================================
$routes->get('/siswa/baca_modul/(:num)', 'Siswa::baca_modul/$1');
$routes->get('/siswa/isi_kuesioner/(:num)', 'Siswa::isi_kuesioner/$1');
$routes->get('/siswa/modul/kuis/(:num)', 'Siswa::kuis_modul/$1');
$routes->post('/siswa/modul/proses_kuis/(:num)', 'Siswa::proses_kuis/$1');
$routes->post('/siswa/simpan_jawaban_kuesioner', 'Siswa::simpan_jawaban_kuesioner');

// Rute Guru
$routes->get('/guru/dashboard', 'Guru::dashboard');

// ==========================================
// RUTE PROFIL PENGGUNA (GLOBAL)
// ==========================================
$routes->get('/profil', 'Profil::index');
$routes->post('/profil/update', 'Profil::update');