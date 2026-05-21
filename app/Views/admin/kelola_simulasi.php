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
    <title>Manajemen Simulasi - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-blue { background-color: #3B82F6; box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-blue:active { box-shadow: inset 4px 4px 8px rgba(29, 78, 216, 0.6), inset -4px -4px 8px rgba(96, 165, 250, 0.5); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-blue-600 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
                <span class="text-xl md:text-2xl mb-1 grayscale group-hover:grayscale-0 transition transform group-hover:-translate-y-1 text-gray-400 group-hover:text-indigo-500">🔐</span>
                
                <!-- Teks "Akses" dengan Ikon Panah Ke Atas -->
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full text-gray-400 group-hover:text-indigo-500 flex items-center justify-center gap-0.5">
                    Akses
                    <svg class="w-2.5 h-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path>
                    </svg>
                </span>
                
                <!-- Popup Melayang -->
                <div id="menuAkses" class="hidden absolute bottom-full left-1/2 transform -translate-x-1/2 mb-3 bg-white rounded-2xl shadow-xl border border-gray-200 w-36 py-2 flex flex-col z-50 transition-all">
                    <!-- Segitiga penunjuk ke bawah -->
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-white rotate-45 border-b border-r border-gray-200"></div>
                    
                    <a href="/admin/kelola_sekolah" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-green-600 hover:bg-green-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">🏫</span> Sekolah
                    </a>
                    <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">👥</span> Pengguna
                    </a>
                    <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">💡</span> Afirmasi
                    </a>
                </div>
            </div>
            <!-- ========================================================= -->
            
            <a href="/admin/ekspor_riset" class="flex-1 flex flex-col items-center text-gray-400 hover:text-purple-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Ekspor</span> </a>
            
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

    <!-- Script agar menu dropup tertutup otomatis jika area lain di layar diklik -->
    <script>
        document.addEventListener('click', function(event) {
            const menuAkses = document.getElementById('menuAkses');
            if (menuAkses && !menuAkses.classList.contains('hidden')) {
                menuAkses.classList.add('hidden');
            }
        });
    </script>

<body class="p-6 font-sans text-gray-700 pb-28">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Manajemen Konten</h1>
            <p class="text-sm font-medium text-gray-500">Panel Admin Skenario CBT</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-6 text-sm text-center font-bold neu-flat border-l-4 border-green-500">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <a href="/admin/tambah_simulasi" class="neu-btn-blue block text-center text-white font-bold py-4 rounded-2xl mb-8 transition">
        + Tambah Skenario Simulasi Baru
    </a>

    <!-- Daftar Simulasi Dinamis -->
    <div class="space-y-4 pb-10">
        <?php if(empty($daftar_simulasi)): ?>
            <div class="neu-pressed p-6 rounded-3xl text-center text-gray-500">Belum ada skenario di database.</div>
        <?php else: ?>
            <?php foreach($daftar_simulasi as $simulasi): ?>
                <div class="neu-flat p-5 rounded-2xl flex justify-between items-center">
                    <div class="flex-1">
                        <span class="text-xs font-bold text-orange-500 bg-orange-100 px-2 py-1 rounded-md">ID: <?= esc($simulasi['id_skenario']) ?></span>
                        <h2 class="text-md font-bold text-gray-800 mt-2"><?= esc($simulasi['judul_simulasi']) ?></h2>
                    </div>
                    <div class="flex space-x-3 ml-4">
                        <a href="/admin/edit_simulasi/<?= $simulasi['id_skenario'] ?>" class="w-10 h-10 neu-flat rounded-full flex items-center justify-center text-blue-500 hover:text-blue-700 active:neu-pressed">✏️</a>
                        <a href="/admin/hapus_simulasi/<?= $simulasi['id_skenario'] ?>" onclick="return confirm('Yakin ingin menghapus skenario ini permanen?')" class="w-10 h-10 neu-flat rounded-full flex items-center justify-center text-red-500 hover:text-red-700 active:neu-pressed">🗑️</a>
                    </div>
                    <a href="/admin/laporan_simulasi/<?= $simulasi['id_skenario'] ?>" class="text-[10px] bg-teal-100 text-teal-600 px-3 py-1.5 rounded-lg font-bold hover:bg-teal-200 transition">📊 Laporan Siswa</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>
