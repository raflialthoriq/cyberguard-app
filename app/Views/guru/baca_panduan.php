<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($panduan['judul_panduan']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);}</style>
</head>
<body class="p-6 font-sans container mx-auto lg:max-w-4xl pb-32">
    <div class="flex justify-between items-center mb-6">
        <div>
            <span class="text-xs font-black text-orange-500 uppercase tracking-widest">[<?= esc($panduan['kode_panduan']) ?>] Materi Fasilitator</span>
            <h1 class="text-2xl font-black text-gray-800 mt-1"><?= esc($panduan['judul_panduan']) ?></h1>
            <p class="text-xs text-gray-500 font-bold mt-1"><?= esc($panduan['deskripsi']) ?></p>
        </div>
    </div>

    <div class="neu-flat p-4 md:p-6 rounded-3xl bg-[#E0E5EC] mb-6 border border-white/60">
        
        <?php if($panduan['tipe_media'] === 'youtube' && !empty($panduan['url_youtube'])): ?>
            <?php 
                // Ekstraksi ID YouTube cerdas dari berbagai format link
                preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $panduan['url_youtube'], $match);
                $youtube_id = $match[1] ?? '';
            ?>
            <div class="aspect-w-16 aspect-h-9 w-full rounded-2xl overflow-hidden shadow-inner">
                <iframe src="https://www.youtube.com/embed/<?= $youtube_id ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-64 md:h-[450px]"></iframe>
            </div>
            
        <?php elseif($panduan['tipe_media'] === 'gambar' && !empty($panduan['file_media'])): ?>
            <img src="/uploads/panduan/<?= esc($panduan['file_media']) ?>" alt="Infografis Panduan" class="w-full rounded-2xl shadow-inner">
            
        <?php elseif($panduan['tipe_media'] === 'audio' && !empty($panduan['file_media'])): ?>
            <div class="bg-gray-800 p-6 rounded-2xl text-center shadow-inner">
                <span class="text-4xl block mb-4">🎙️</span>
                <audio controls class="w-full">
                    <source src="/uploads/panduan/<?= esc($panduan['file_media']) ?>" type="audio/mpeg">
                    Browser Anda tidak mendukung elemen audio.
                </audio>
            </div>
            
        <?php elseif($panduan['tipe_media'] === 'dokumen' && !empty($panduan['file_media'])): ?>
            <div class="w-full rounded-2xl overflow-hidden shadow-inner bg-gray-100">
                <iframe src="/uploads/panduan/<?= esc($panduan['file_media']) ?>" class="w-full h-96 md:h-[600px]" frameborder="0"></iframe>
            </div>
        <?php endif; ?>

        <div class="mt-6 pt-6 border-t border-gray-300">
            <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest mb-4">Teks Panduan Lengkap</h3>
            <div class="prose text-gray-700 font-medium leading-relaxed text-sm md:text-base whitespace-pre-line text-justify">
                <?= $panduan['konten_panduan'] ? $panduan['konten_panduan'] : '<p class="text-gray-400 italic">Materi bacaan kosong.</p>' ?>
            </div>
        </div>
    </div>

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
</body>
</html>