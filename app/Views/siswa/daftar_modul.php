<?php
/**
 * @var array $daftar_modul
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul Belajar - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat {
            background-color: #E0E5EC;
            box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7);
        }
        .neu-pressed {
            background-color: #E0E5EC;
            box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1);
        }
    </style>
</head>

<!-- ============================================================== -->
    <!-- BOTTOM NAVIGATION BAR (BELAJAR AKTIF)                          -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            
            <a href="/siswa/modul" class="flex flex-col items-center text-teal-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 drop-shadow-md">📚</span>
                <span class="text-[10px] font-extrabold">Belajar</span>
            </a>
            
            <a href="/siswa/simulasi" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">🎮</span>
                <span class="text-[10px] font-bold">Latihan</span>
            </a>
            
            <a href="/siswa/jurnal" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">📔</span>
                <span class="text-[10px] font-bold">Jurnal</span>
            </a>
            
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">👤</span>
                <span class="text-[10px] font-bold">Profil</span>
            </a>
            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>

        </div>
    </nav>

<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-28">

    <!-- Header -->
    <div class="p-6 flex items-center mb-4">
        <a href="/siswa/beranda" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4">←</a>
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Pilih Modul</h1>
    </div>

    <!-- Daftar Modul -->
    <!-- Daftar Modul -->
    <div class="px-6 flex-1 pb-10">
        
        <!-- BLOK KODE ALERT / NOTIFIKASI YANG BARU DITAMBAHKAN -->
       <!-- Pesan Sukses (Hijau) -->
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="bg-white text-green-600 p-4 rounded-2xl mb-6 text-sm text-center font-bold neu-flat border-l-4 border-green-500">
                <?= session()->getFlashdata('pesan_sukses') ?>
            </div>
        <?php endif; ?>

        <!-- Pesan Gagal (Merah) -->
        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-white text-red-600 p-4 rounded-2xl mb-6 text-sm text-center font-bold neu-flat border-l-4 border-red-500">
                <?= session()->getFlashdata('pesan_gagal') ?>
            </div>
        <?php endif; ?>

        <!-- Loop Item Pembelajaran (Modul & Kuesioner yang sudah diurutkan) -->
        <div class="space-y-4">
            <?php foreach($daftar_item as $item): ?>
                
                <?php if($item['tipe'] === 'modul'): ?>
                    <!-- ============================================== -->
                    <!-- TAMPILAN UNTUK ITEM MODUL                      -->
                    <!-- ============================================== -->
                    <div class="neu-pressed p-5 rounded-3xl <?= $item['status'] === 'terkunci' ? 'opacity-60' : '' ?>">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-extrabold text-gray-800 text-sm md:text-base"><?= esc($item['judul']) ?></h3>
                            <span class="text-xl"><?= $item['status'] === 'terkunci' ? '🔒' : ($item['status'] === 'selesai' ? '✅' : '📖') ?></span>
                        </div>
                        <p class="text-[10px] md:text-xs font-bold text-gray-500 mb-4"><?= esc($item['deskripsi']) ?></p>
                        
                        <?php if($item['status'] !== 'terkunci'): ?>
                            <a href="/siswa/baca_modul/<?= $item['id'] ?>" class="block w-full text-center neu-flat text-teal-600 font-extrabold py-3 rounded-xl hover:text-teal-800 transition active:scale-95 text-[10px] uppercase tracking-widest">
                                Buka Modul
                            </a>
                        <?php endif; ?>
                    </div>
                
               <?php else: ?>
                    <!-- ============================================== -->
                    <!-- TAMPILAN UNTUK ITEM KUESIONER                  -->
                    <!-- ============================================== -->
                    <!-- Tambahkan pengecekan opacity jika terkunci -->
                    <div class="neu-pressed p-5 rounded-3xl border-l-4 border-purple-500 bg-purple-50/20 <?= $item['status'] === 'terkunci' ? 'opacity-60 grayscale' : '' ?>">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-extrabold text-purple-700 text-sm md:text-base"><?= esc($item['judul']) ?></h3>
                            <!-- Ubah Ikon sesuai status (Gembok/Centang/Pensil) -->
                            <span class="text-xl">
                                <?= $item['status'] === 'terkunci' ? '🔒' : ($item['status'] === 'selesai' ? '✅' : '📝') ?>
                            </span>
                        </div>
                        <p class="text-[10px] md:text-xs font-bold text-purple-500/80 mb-4"><?= esc($item['deskripsi']) ?></p>
                        
                        <!-- Logika Tombol Dinamis -->
                        <?php if($item['status'] === 'aktif'): ?>
                            <a href="/siswa/isi_kuesioner/<?= $item['id'] ?>" class="block w-full text-center bg-purple-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-purple-600 transition active:scale-95 text-[10px] uppercase tracking-widest">
                                Isi Kuesioner
                            </a>
                        <?php elseif($item['status'] === 'selesai'): ?>
                            <button disabled class="w-full text-center bg-purple-200 text-purple-500 font-extrabold py-3 rounded-xl cursor-not-allowed text-[10px] uppercase tracking-widest">
                                Sudah Diselesaikan
                            </button>
                        <?php else: ?>
                            <button disabled class="w-full text-center neu-flat text-gray-400 font-extrabold py-3 rounded-xl cursor-not-allowed text-[10px] uppercase tracking-widest">
                                Terkunci
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>

    </div>

</body>
</html>