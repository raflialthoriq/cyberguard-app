<?php
namespace App\Models;
use CodeIgniter\Model;

class ProgresSiswaModel extends Model {
    protected $table = 'progres_siswa';
    protected $primaryKey = 'id_progres';
    protected $allowedFields = ['id_pengguna', 'id_modul', 'status_modul', 'skor_kuis', 'detail_jawaban', 'tanggal_selesai'];
}