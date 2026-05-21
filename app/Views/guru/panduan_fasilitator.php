<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pustaka Panduan Fasilitator - CyberGuard</title>
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
            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-orange-500 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>
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
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Pustaka Panduan 📚</h1>
            <p class="text-sm font-bold text-gray-500 mt-1">Materi referensi dan panduan intervensi untuk Fasilitator.</p>
        </div>
    </div>

    <!-- Kolom Pencarian -->
    <div class="mb-8">
        <div class="neu-pressed flex items-center px-5 py-3 rounded-2xl w-full">
            <span class="text-gray-400 mr-3">🔍</span>
            <input type="text" placeholder="Cari topik diskusi, materi, atau panduan..." class="bg-transparent focus:outline-none w-full text-sm font-bold text-gray-600">
        </div>
    </div>

    <!-- Konten Pustaka -->
    <div class="space-y-6">
        
        <!-- Kategori 1: Reference Teaching -->
        <div>
            <h2 class="text-lg font-extrabold text-gray-700 mb-4 px-2">Reference Teaching</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="#" class="neu-flat p-4 rounded-3xl flex items-center justify-between hover:text-orange-500 transition active:neu-pressed group">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">📘</span>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 group-hover:text-orange-500">Panduan Memulai Program</h3>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">G1 - PDF (1.2 MB)</p>
                        </div>
                    </div>
                    <span class="text-gray-400 font-bold text-xl">⬇️</span>
                </a>
                <a href="#" class="neu-flat p-4 rounded-3xl flex items-center justify-between hover:text-orange-500 transition active:neu-pressed group">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">📊</span>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 group-hover:text-orange-500">Panduan Membaca Dashboard</h3>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">G3 - PDF (2.5 MB)</p>
                        </div>
                    </div>
                    <span class="text-gray-400 font-bold text-xl">⬇️</span>
                </a>
            </div>
        </div>

        <!-- Kategori 2: Discussion Scenarios -->
        <div>
            <h2 class="text-lg font-extrabold text-gray-700 mb-4 px-2">Discussion Scenarios</h2>
            <div class="grid grid-cols-1 gap-4">
                <a href="#" class="neu-flat p-4 rounded-3xl flex items-center justify-between hover:text-orange-500 transition active:neu-pressed group border-l-4 border-orange-400">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">🗣️</span>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 group-hover:text-orange-500">Skenario Diskusi: Cyberbullying</h3>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">G2 - Panduan Dialog Tanpa Menghakimi</p>
                        </div>
                    </div>
                    <span class="text-gray-400 font-bold text-xl">⬇️</span>
                </a>
                <a href="#" class="neu-flat p-4 rounded-3xl flex items-center justify-between hover:text-orange-500 transition active:neu-pressed group border-l-4 border-teal-400">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">🤝</span>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 group-hover:text-orange-500">Teknik Konseling Singkat</h3>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">G4 - Untuk Kasus Ringan (15 Menit)</p>
                        </div>
                    </div>
                    <span class="text-gray-400 font-bold text-xl">⬇️</span>
                </a>
            </div>
        </div>

        <!-- Kategori 3: Presentation Materials -->
        <div>
            <h2 class="text-lg font-extrabold text-gray-700 mb-4 px-2">Presentation Materials</h2>
            <div class="grid grid-cols-1 gap-4">
                <a href="#" class="neu-flat p-4 rounded-3xl flex items-center justify-between hover:text-orange-500 transition active:neu-pressed group border-l-4 border-blue-400">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">👨‍👩‍👧</span>
                        <div>
                            <h3 class="font-bold text-sm text-gray-800 group-hover:text-orange-500">Materi Presentasi Orang Tua</h3>
                            <p class="text-[10px] text-gray-400 font-bold mt-1">G5 - Slide PPT & Tips Pengawasan</p>
                        </div>
                    </div>
                    <span class="text-gray-400 font-bold text-xl">⬇️</span>
                </a>
            </div>
        </div>

    </div>

</body>
</html>