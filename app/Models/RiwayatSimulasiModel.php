<?php
namespace App\Models;
use CodeIgniter\Model;

class RiwayatSimulasiModel extends Model
{
    protected $table            = 'riwayat_simulasi';
    protected $primaryKey       = 'id_riwayat_simulasi';
    protected $allowedFields    = ['id_pengguna', 'id_skenario', 'skor_kontrol_diri', 'tanggal_percobaan'];
}