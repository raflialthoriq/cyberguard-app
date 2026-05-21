<?php
namespace App\Models;
use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id_kelas';
    
    // Pastikan hanya 3 kolom ini yang diizinkan (sesuai database aslimu)
    protected $allowedFields    = ['nama_kelas', 'id_guru', 'kode_kelas'];
    
    // MATIKAN FITUR WAKTU OTOMATIS:
    protected $useTimestamps    = false; 
}