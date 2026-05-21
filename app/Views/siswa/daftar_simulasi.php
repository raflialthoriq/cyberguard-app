<?php
/**
 * @var array $daftar_simulasi
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Simulasi - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
    </style>
</head>

<!-- ============================================================== -->
    <!-- BOTTOM NAVIGATION BAR (LATIHAN AKTIF)                          -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            
            <a href="/siswa/modul" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">📚</span>
                <span class="text-[10px] font-bold">Belajar</span>
            </a>
            
            <a href="/siswa/simulasi" class="flex flex-col items-center text-orange-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 drop-shadow-md">🎮</span>
                <span class="text-[10px] font-extrabold">Latihan</span>
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
        <a href="/siswa/beranda" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4 flex-shrink-0">←</a>
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Pilih Simulasi</h1>
    </div>

    <!-- Daftar Simulasi -->
    <div class="px-6 flex-1 pb-10">
        
        <!-- Notifikasi Feedback CBT (Hijau jika skor positif) -->
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="bg-white text-green-600 p-5 rounded-2xl mb-8 text-sm font-bold neu-flat border-l-4 border-green-500 leading-relaxed">
                <?= session()->getFlashdata('pesan_sukses') ?>
            </div>
        <?php endif; ?>

        <!-- Notifikasi Feedback CBT (Merah jika skor negatif) -->
        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-white text-red-600 p-5 rounded-2xl mb-8 text-sm font-bold neu-flat border-l-4 border-red-500 leading-relaxed">
                <?= session()->getFlashdata('pesan_gagal') ?>
            </div>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if(empty($daftar_simulasi)): ?>
                <div class="neu-pressed p-6 rounded-3xl text-center text-gray-500 font-bold">
                    Belum ada skenario simulasi yang tersedia.
                </div>
            <?php else: ?>
                <?php foreach($daftar_simulasi as $index => $simulasi): ?>
                    
                    <a href="/siswa/simulasi/main/<?= $simulasi['id_skenario'] ?>" class="block neu-flat hover:scale-[1.02] transition-transform p-5 rounded-3xl flex items-center">
                        
                        <!-- Ikon Game/Simulasi -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-xl font-bold mr-4 neu-flat text-blue-500 flex-shrink-0">
                            🎮
                        </div>

                        <!-- Judul Simulasi -->
                        <div class="flex-1">
                            <p class="text-xs font-bold uppercase text-blue-500 mb-1">Skenario <?= $index + 1 ?></p>
                            <h2 class="text-sm font-bold text-gray-700 leading-tight"><?= esc($simulasi['judul_simulasi']) ?></h2>
                            <span class="text-xs text-orange-500 font-bold mt-2 inline-block bg-orange-100 px-2 py-1 rounded-md">Mulai Simulasi →</span>
                        </div>
                    </a>
                    
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>