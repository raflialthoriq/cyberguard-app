<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Jika pengguna sudah login, mereka tetap bisa mengakses beranda utama ini
        // Tombol di navbar nantinya akan menyesuaikan (berubah menjadi tombol "Ke Dasbor")
        return view('welcome_message');
    }
}