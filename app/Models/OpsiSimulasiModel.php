<?php
namespace App\Models;
use CodeIgniter\Model;

class OpsiSimulasiModel extends Model
{
    protected $table            = 'opsi_simulasi';
    protected $primaryKey       = 'id_opsi';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_skenario', 'teks_opsi', 'feedback_opsi', 'skor_opsi'];
}