<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatSimulasiModel extends Model
{
    protected $table            = 'riwayat_simulasi';
    protected $primaryKey       = 'id_riwayat_simulasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // PERBAIKAN: Menambahkan 'id_opsi_terpilih'
    protected $allowedFields = [
        'id_pengguna', 'id_skenario', 'id_opsi_terpilih', 'skor_kontrol_diri', 'tanggal_percobaan'
    ];
}