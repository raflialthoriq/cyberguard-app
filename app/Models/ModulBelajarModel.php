<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulBelajarModel extends Model
{
    protected $table            = 'modul_belajar';
    protected $primaryKey       = 'id_modul';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    protected $allowedFields = [
        'judul_modul', 'konten_materi', 'urutan_modul', 
        'tipe_media', 'file_media', 'url_youtube'
    ];
    // ...
}