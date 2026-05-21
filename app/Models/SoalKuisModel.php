<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalKuisModel extends Model
{
    protected $table            = 'soal_kuis';
    protected $primaryKey       = 'id_soal';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_modul', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'jawaban_benar'
    ];
}