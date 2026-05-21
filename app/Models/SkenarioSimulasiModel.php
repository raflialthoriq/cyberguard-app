<?php

namespace App\Models;

use CodeIgniter\Model;

class SkenarioSimulasiModel extends Model
{
    protected $table            = 'skenario_simulasi';
    protected $primaryKey       = 'id_skenario';
    protected $returnType       = 'array';
    
    // BARIS INI WAJIB ADA: Hanya mengizinkan judul dan deskripsi untuk disimpan
    protected $allowedFields    = [
        'judul_simulasi', 'deskripsi_kasus'
    ];
}