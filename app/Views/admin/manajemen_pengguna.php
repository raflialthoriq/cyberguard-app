<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);}</style>
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
    
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Manajemen Pengguna 👥</h1>
            <p class="text-sm font-bold text-gray-500">Pantau dan kelola akses akun Guru & Siswa.</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-white/50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl mb-6 text-sm font-bold neu-flat">
            <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="neu-flat p-6 rounded-3xl overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-widest text-gray-500 border-b-2 border-gray-300">
                    <th class="py-3 px-4">Profil Pengguna</th>
                    <th class="py-3 px-4">Peran</th>
                    <th class="py-3 px-4">Status Akun</th>
                    <th class="py-3 px-4 text-center">Aksi Moderasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($daftar_pengguna as $p): ?>
                <tr class="border-b border-gray-300/50 hover:bg-white/30 transition">
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-800"><?= esc($p['nama_lengkap']) ?></p>
                        <p class="text-[10px] font-bold text-gray-500"><?= esc($p['email']) ?> <?= $p['nama_sekolah'] ? ' | ' . esc($p['nama_sekolah']) : '' ?></p>
                    </td>
                    <td class="py-4 px-4">
                        <span class="px-2 py-1 text-[10px] rounded-md font-bold uppercase tracking-wider <?= $p['peran'] == 'guru' ? 'bg-teal-100 text-teal-600' : 'bg-blue-100 text-blue-600' ?>">
                            <?= esc($p['peran']) ?>
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <?php if($p['status_aktif'] == 1): ?>
                            <span class="text-xs font-bold text-green-600">🟢 Aktif</span>
                        <?php else: ?>
                            <span class="text-xs font-bold text-red-600">🔴 Ditangguhkan</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <?php if($p['status_aktif'] == 1): ?>
                            <a href="/admin/toggle_status_pengguna/<?= $p['id_pengguna'] ?>" onclick="return confirm('Yakin ingin menangguhkan (suspend) akun ini? Pengguna tidak akan bisa login.')" class="inline-block bg-red-100 text-red-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-red-200 transition">
                                🔒 Suspend Akun
                            </a>
                        <?php else: ?>
                            <a href="/admin/toggle_status_pengguna/<?= $p['id_pengguna'] ?>" onclick="return confirm('Aktifkan kembali akun ini?')" class="inline-block bg-green-100 text-green-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-green-200 transition">
                                🔓 Aktifkan Kembali
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>