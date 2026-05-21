<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Cepat - CyberGuard</title>
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
            <a href="/guru/beranda" class="flex flex-col items-center text-gray-400 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📊</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚨</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-purple-600 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📄</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>
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
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Modul Laporan Cepat 📄</h1>
            <p class="text-sm font-bold text-gray-500 mt-1">Bantu Anda menyusun laporan evaluasi program untuk Kepala Sekolah.</p>
        </div>
    </div>

    <!-- Filter Data -->
    <div class="mb-6">
        <h3 class="font-bold text-gray-600 text-sm mb-3">Filter Data</h3>
        <div class="neu-flat flex items-center px-5 py-4 rounded-2xl w-full">
            <span class="text-gray-400 mr-3 text-xl">📅</span>
            <input type="text" value="<?= esc($filter_bulan) ?>" readonly class="bg-transparent focus:outline-none w-full text-sm font-bold text-gray-700 cursor-pointer">
            <span class="text-gray-400 font-bold ml-2">▼</span>
        </div>
    </div>

    <!-- Auto-generated Statistics -->
    <div class="mb-8">
        <h3 class="font-bold text-gray-600 text-sm mb-3">Auto-generated statistics</h3>
        
        <div class="grid grid-cols-2 gap-4">
            <!-- Statistik 1: Sesi Simulasi -->
            <div class="neu-pressed p-5 rounded-3xl flex flex-col justify-center items-center text-center">
                <span class="text-3xl font-black text-gray-800"><?= esc($sesi_simulasi_selesai) ?></span>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 mt-2">Count Session Simulation Completed</p>
            </div>
            
            <!-- Statistik 2: Peningkatan Skor -->
            <div class="neu-pressed p-5 rounded-3xl flex flex-col justify-center items-center text-center">
                <span class="text-3xl font-black text-green-500"><?= esc($peningkatan_skor) ?></span>
                <p class="text-[10px] md:text-xs font-bold text-gray-500 mt-2">Average Pre-test to Post-test score improvement</p>
            </div>
        </div>
    </div>

    <!-- Tombol Ekspor -->
    <div class="mt-4">
        <button onclick="alert('Fitur Generate PDF menggunakan library dompdf/MPDF akan dipasang di tahap selanjutnya.')" class="w-full bg-green-600 text-white font-extrabold py-4 rounded-2xl shadow-lg hover:bg-green-700 transition active:scale-95 text-sm md:text-base flex justify-center items-center">
            📥 Ekspor Laporan ke PDF
        </button>
    </div>

</body>
</html>