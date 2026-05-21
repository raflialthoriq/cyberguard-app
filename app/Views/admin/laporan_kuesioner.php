<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan: <?= esc($kuesioner['judul_kuesioner']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #E0E5EC; } .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); }</style>
</head>

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-blue-600  hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
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
    
<body class="pb-28 font-sans text-gray-700 container mx-auto px-4 lg:max-w-4xl min-h-screen pt-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Laporan Kuesioner 📊</h1>
            <p class="text-sm font-bold text-purple-600"><?= esc($kuesioner['judul_kuesioner']) ?></p>
        </div>
        <a href="/admin/kelola_kuesioner" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500 hover:text-gray-800">⬅️ Kembali</a>
    </div>

    <div class="neu-flat p-6 rounded-3xl">
        <h2 class="font-extrabold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">Daftar Partisipan (<?= count($partisipan) ?> Siswa)</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs uppercase tracking-widest text-gray-500 border-b-2 border-gray-300">
                        <th class="py-3 px-4">Nama Siswa</th>
                        <th class="py-3 px-4">Asal Sekolah</th>
                        <th class="py-3 px-4">Tanggal Isi</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($partisipan as $p): ?>
                    <tr class="border-b border-gray-300/50 hover:bg-white/30 transition">
                        <td class="py-3 px-4 font-bold text-gray-800"><?= esc($p['nama_lengkap']) ?><br><span class="text-[10px] text-gray-500 font-normal"><?= esc($p['email']) ?></span></td>
                        <td class="py-3 px-4 text-xs font-bold"><?= esc($p['nama_sekolah'] ?? '-') ?></td>
                        <td class="py-3 px-4 text-xs"><?= date('d M Y, H:i', strtotime($p['tanggal_isi'])) ?></td>
                        <td class="py-3 px-4">
                            <a href="/admin/detail_jawaban_kuesioner/<?= $p['id_partisipasi'] ?>" class="bg-purple-500 text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-purple-600">Lihat Jawaban</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($partisipan)): ?>
                        <tr><td colspan="4" class="py-8 text-center font-bold text-gray-400">Belum ada siswa yang mengisi kuesioner ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>