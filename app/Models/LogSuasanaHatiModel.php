<?php

namespace App\Models;

use CodeIgniter\Model;

class LogSuasanaHatiModel extends Model
{
    protected $table            = 'log_suasana_hati';
    protected $primaryKey       = 'id_jurnal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = [
        'id_pengguna', 'suasana_hati', 'teks_jurnal', 'tanggal_jurnal'
    ];
}