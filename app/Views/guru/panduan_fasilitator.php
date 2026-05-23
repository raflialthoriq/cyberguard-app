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

    <div class="space-y-4">
    <?php foreach($daftar_panduan as $p): ?>
        <div class="neu-flat p-5 rounded-2xl flex items-center justify-between group hover:bg-orange-50/20 transition">
            <div class="flex items-center space-x-4">
                <span class="text-3xl">📘</span>
                <div>
                    <span class="text-[10px] font-black text-orange-500 uppercase tracking-widest"><?= esc($p['kode_panduan']) ?> - Reference Material</span>
                    <h3 class="font-bold text-sm text-gray-800 mt-0.5"><?= esc($p['judul_panduan']) ?></h3>
                    <p class="text-xs text-gray-400 font-medium mt-1"><?= esc($p['deskripsi']) ?></p>
                </div>
            </div>
            <div class="flex gap-2 mt-3 md:mt-0">
    <a href="/guru/baca_panduan/<?= $p['id_panduan'] ?>" class="bg-indigo-600 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-sm hover:bg-indigo-700 transition flex items-center gap-1">
        📖 Baca Langsung
    </a>
    <button onclick="alert('Mengunduh lampiran...')" class="neu-flat text-gray-600 font-bold text-xs px-3 py-2 rounded-xl">⬇️ PDF</button>
</div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>