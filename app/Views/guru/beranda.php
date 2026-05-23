<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru BK - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex flex-col items-center text-teal-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📊</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚨</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📄</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>
    
<body class="pb-28 p-4 p-6 font-sans text-gray-700 min-h-screen flex flex-col relative">

    <!-- Header & Profil -->
    <div class="flex justify-between items-center mb-6 neu-flat p-5 rounded-3xl">
        <div class="flex items-center space-x-4">
            <!-- Avatar Inisial (Bisa diganti dinamis nanti) -->
            <div class="w-14 h-14 md:w-16 md:h-16 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl md:text-3xl border-2 border-white overflow-hidden neu-pressed">
                <?php if(session()->get('url_avatar')): ?>
                    <img src="/<?= esc(session()->get('url_avatar')) ?>" alt="Avatar" class="w-full h-full object-cover">
                <?php else: ?>
                    <?= strtoupper(substr(session()->get('nama_panggilan'), 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-gray-800 leading-tight">Selamat Datang,</h1>
                <p class="text-teal-600 font-bold text-sm"><?= esc(session()->get('nama_lengkap') ?? 'Bapak/Ibu Guru') ?></p>
            </div>
        </div>
        <a href="/auth/logout" class="text-red-500 font-bold text-xs px-4 py-2 neu-pressed rounded-full hover:text-red-700 transition">Logout</a>
    </div>

    <!-- Ringkasan Statistik Agregat (Card View) -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        <!-- Card 1: Total Siswa -->
        <div class="neu-flat p-5 rounded-3xl flex flex-col justify-center items-center text-center">
            <a href="/guru/total_siswa_aktif" class="block cursor-pointer transition transform hover:scale-95"><h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Total Siswa Aktif</h3></a>
           <span class="text-4xl font-black text-blue-600"><?= $total_siswa ?></span>
            <p class="text-[10px] text-gray-400 mt-2">Siswa terdaftar</p>
        </div>

        <!-- Card 2: Rata-rata Progres -->
        <div class="neu-flat p-5 rounded-3xl flex flex-col justify-center items-center text-center">
            <h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Rata-rata Progres Modul</h3>
            <span class="text-4xl font-black text-teal-500"><?= $rata_progres ?>%</span>
            <p class="text-[10px] text-gray-400 mt-2">Penyelesaian agregat</p>
        </div>

        <!-- Card 3: Perlu Perhatian -->
        <div class="neu-flat p-5 rounded-3xl flex flex-col justify-center items-center text-center col-span-2 md:col-span-1">
            <a href="/guru/siswa_perhatian" class="block cursor-pointer transition transform hover:scale-95"><h3 class="text-xs font-bold text-gray-500 mb-2 uppercase tracking-wide">Siswa Perlu Perhatian</h3>
            <span class="text-4xl font-black text-red-500"><?= $siswa_perhatian ?></span>
            <p class="text-[10px] text-gray-400 mt-2">Butuh intervensi dini</p></a>
            
        </div>
    </div>

    <!-- Area Grafik Mini (Placeholder Data) -->
    <div class="neu-flat p-6 rounded-3xl w-full mb-8">
        <h2 class="font-bold text-gray-700 mb-4 flex items-center text-sm md:text-base">
            📈 Aktivitas Harian Siswa Minggu Ini
        </h2>
        
        <!-- Placeholder Grafik Batang Sederhana (Akan dibuat dinamis nanti) -->
        <div class="h-40 flex items-end justify-between space-x-2 border-b-2 border-gray-300 pb-2">
            <div class="w-full bg-blue-200 rounded-t-md h-[20%] neu-pressed"></div>
            <div class="w-full bg-blue-300 rounded-t-md h-[40%] neu-pressed"></div>
            <div class="w-full bg-blue-400 rounded-t-md h-[70%] neu-pressed"></div>
            <div class="w-full bg-blue-500 rounded-t-md h-[50%] neu-pressed"></div>
            <div class="w-full bg-teal-400 rounded-t-md h-[85%] neu-pressed"></div>
            <div class="w-full bg-teal-500 rounded-t-md h-[30%] neu-pressed"></div>
            <div class="w-full bg-gray-300 rounded-t-md h-[10%] neu-pressed"></div>
        </div>
        <div class="flex justify-between text-[10px] md:text-xs font-bold text-gray-500 mt-2 px-1">
            <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span>Min</span>
        </div>
    </div>

</body>
</html>