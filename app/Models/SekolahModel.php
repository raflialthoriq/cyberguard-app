<?php
namespace App\Models;
use CodeIgniter\Model;

class SekolahModel extends Model
{
    protected $table            = 'sekolah';
    protected $primaryKey       = 'id_sekolah';
    protected $allowedFields    = ['nama_sekolah', 'kode_otorisasi']; 
}