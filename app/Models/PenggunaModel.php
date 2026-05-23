<?php

namespace App\Models;

use CodeIgniter\Model;

class PenggunaModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id_pengguna';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang diizinkan untuk diisi secara manual (Mass Assignment)
    protected $allowedFields = [
        'nama_lengkap', 'nama_panggilan', 'email', 'kata_sandi', 'peran', 
        'status_aktif', 'token_verifikasi', 'token_reset', 'reset_kedaluwarsa', 
        'url_avatar', 'jabatan', 'nip', 'nama_sekolah', 'id_guru', 'id_kelas', 
        'skor_kesejahteraan', 'terakhir_login', 'streak_login', 'otp_code', 'otp_expired_at'
    ];

    // Fungsi tambahan untuk mengambil data siswa berdasarkan Guru BK
    public function getSiswaByGuru($id_guru)
    {
        return $this->where('id_guru', $id_guru)
                    ->where('peran', 'siswa')
                    ->findAll();
    }
}