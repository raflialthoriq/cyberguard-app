<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervensi Dini - CyberGuard</title>
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
            <a href="/guru/beranda" class="flex flex-col items-center text-gray-400  transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📊</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-red-500 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">🚨</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span> </a>
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

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Daftar Siswa Prioritas 🚩</h1>
            <p class="text-sm font-bold text-gray-500 mt-1">Siswa terindikasi memiliki masalah keterlibatan atau skor *wellbeing* rendah.</p>
        </div>
    </div>

    <!-- Daftar Siswa Ter-flag -->
    <div class="space-y-5">
        <?php if(empty($daftar_flagged)): ?>
            <div class="neu-pressed p-8 rounded-3xl text-center text-teal-600 font-bold flex flex-col items-center">
                <span class="text-4xl mb-3">🎉</span>
                Kabar Baik! Tidak ada siswa yang memerlukan intervensi mendesak saat ini.
            </div>
        <?php else: ?>
            <?php foreach($daftar_flagged as $siswa): ?>
                <!-- Card Siswa -->
                <div class="neu-flat p-5 rounded-3xl border-l-4 <?= $siswa['keparahan'] == 'high' ? 'border-red-500' : 'border-yellow-500' ?>">
                    <div class="flex items-center space-x-4 mb-4">
                        <!-- Inisial (Privasi) -->
                        <div class="w-12 h-12 rounded-full neu-pressed flex items-center justify-center font-black text-gray-600 flex-shrink-0">
                            <?= esc($siswa['inisial']) ?>
                        </div>
                        <div>
                            <h3 class="font-extrabold text-gray-800 text-sm md:text-base">Siswa <?= esc($siswa['inisial']) ?> <span class="text-[10px] font-normal text-gray-400">(Anonim Inisial)</span></h3>
                            <p class="text-xs font-bold <?= $siswa['keparahan'] == 'high' ? 'text-red-500' : 'text-yellow-600' ?> mt-1">
                                Alasan: <?= esc($siswa['alasan']) ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <button onclick="alert('Fitur penjadwalan akan dikembangkan pada fase berikutnya.')" class="w-full neu-pressed text-blue-600 font-bold py-3 rounded-xl hover:text-blue-800 transition active:scale-95 text-sm">
                        📅 Jadwalkan Konseling Tatap Muka
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>