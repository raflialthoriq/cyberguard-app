<?php 
/** 
 * @var array $daftar_sekolah 
 */ 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Sekolah - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-teal { background-color: #0D9488; box-shadow: 4px 4px 8px rgba(13, 148, 136, 0.4), -4px -4px 8px rgba(255,255,255,1); }
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
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
                <span class="text-xl md:text-2xl mb-1 drop-shadow-md transition transform group-hover:-translate-y-1 text-gray-400 group-hover:text-indigo-500">🔐</span>
                
                <!-- Teks "Akses" dengan Ikon Panah Ke Atas -->
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full text-blue-600 group-hover:text-indigo-500 flex items-center justify-center gap-0.5">
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
                    <a href="/admin/kelola_panduan" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">📚</span> Panduan 
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

<body class="p-6 font-sans text-gray-700 min-h-screen flex flex-col pb-28">

    <!-- Header Dashboard -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Manajemen Data Sekolah</h1>
            <p class="text-sm font-medium text-gray-500">Kelola daftar asal sekolah untuk pendaftaran akun.</p>
        </div>
    </div>

    <!-- Notifikasi Sistem -->
    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 text-sm font-bold neu-flat border-l-4 border-green-500">
            ✅ <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Form Tambah Sekolah -->
        <div class="md:col-span-1 h-fit">
            <div class="neu-flat p-6 rounded-3xl">
                <h2 class="font-bold text-teal-600 mb-4 border-b-2 border-gray-300 pb-2 flex items-center">
                    ➕ Tambah Sekolah Baru
                </h2>
                <form action="/admin/simpan_sekolah" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-2 ml-2">Nama Sekolah Lengkap</label>
                        <input type="text" name="nama_sekolah" placeholder="Misal: SMA Negeri 1 Lhokseumawe" class="neu-pressed w-full px-5 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700" required>
                    </div>
                    <button type="submit" class="neu-btn-teal w-full text-white font-bold py-3 rounded-xl transition duration-300 shadow-lg active:scale-95">
                        Simpan ke Database
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabel Daftar Sekolah -->
        <div class="md:col-span-2">
            <div class="neu-flat p-6 rounded-3xl">
                <h2 class="font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2 flex items-center">
                    🏫 Daftar Sekolah Tersedia (<?= count($daftar_sekolah) ?>)
                </h2>
                
                <div class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                    <?php if(empty($daftar_sekolah)): ?>
                        <div class="neu-pressed p-8 rounded-3xl text-center text-gray-500 font-bold">
                            Belum ada data sekolah. Silakan tambahkan melalui borang di samping.
                        </div>
                    <?php else: ?>
                        <?php foreach($daftar_sekolah as $index => $sekolah): ?>
                            <div class="neu-pressed p-4 rounded-2xl flex justify-between items-center">
                                <div class="flex items-center space-x-4 flex-1">
                                    <span class="text-sm font-bold text-teal-500 bg-teal-100 w-8 h-8 flex items-center justify-center rounded-full flex-shrink-0">
                                        <?= $index + 1 ?>
                                    </span>
                                    <div>
                                        <h3 class="font-bold text-gray-700 text-sm"><?= esc($sekolah['nama_sekolah']) ?></h3>
                                        <p class="text-xs font-bold text-red-500 mt-1 flex items-center">
                                            Token: <span class="bg-red-100 px-2 py-1 rounded ml-2 tracking-widest"><?= esc($sekolah['kode_otorisasi'] ?? 'KOSONG') ?></span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2 ml-4">
                                    <!-- Tombol Refresh Kode -->
                                    <a href="/admin/refresh_kode_sekolah/<?= $sekolah['id_sekolah'] ?>" onclick="return confirm('Ganti token untuk sekolah ini? Guru yang sedang mendaftar harus menggunakan token baru.')" class="w-10 h-10 neu-flat rounded-xl flex items-center justify-center text-blue-500 hover:text-blue-700 active:neu-pressed transition-all" title="Perbarui Token">
                                        🔄
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a href="/admin/hapus_sekolah/<?= $sekolah['id_sekolah'] ?>" onclick="return confirm('Hapus sekolah ini?')" class="w-10 h-10 neu-flat rounded-xl flex items-center justify-center text-red-500 hover:text-red-700 active:neu-pressed transition-all" title="Hapus Sekolah">
                                        🗑️
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</body>
</html>