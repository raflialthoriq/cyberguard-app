<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($panduan['judul_panduan']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="p-6 font-sans container mx-auto lg:max-w-4xl pb-28">
    <div class="flex justify-between items-start mb-6 gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <i data-lucide="bookmark" class="w-4 h-4 text-orange-500"></i>

                <span class="text-xs font-black text-orange-500 uppercase tracking-widest">
                    <?= esc($panduan['kode_panduan']) ?> • Materi Fasilitator
                </span>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-gray-800 mt-1 leading-tight"><?= esc($panduan['judul_panduan']) ?></h1>
            <p class="text-xs text-gray-500 font-bold mt-1"><?= esc($panduan['deskripsi']) ?></p>
        </div>
        <a href="/guru/panduan_fasilitator"
            class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-600 flex items-center gap-2 hover:text-green-600 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <div class="neu-flat p-5 md:p-8 rounded-3xl bg-[#E0E5EC] mb-6 border border-white/60 hover:shadow-2xl transition duration-300">

        <?php if ($panduan['tipe_media'] === 'youtube' && !empty($panduan['url_youtube'])): ?>
            <?php
            // Ekstraksi ID YouTube cerdas dari berbagai format link
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $panduan['url_youtube'], $match);
            $youtube_id = $match[1] ?? '';
            ?>
            <div class="aspect-w-16 aspect-h-9 w-full rounded-2xl overflow-hidden shadow-inner">
                <iframe src="https://www.youtube.com/embed/<?= $youtube_id ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-64 md:h-[450px]"></iframe>
            </div>

        <?php elseif ($panduan['tipe_media'] === 'gambar' && !empty($panduan['file_media'])): ?>
            <div class="mb-3 flex items-center gap-2 text-orange-500 font-black text-xs uppercase tracking-wider">
                <i data-lucide="image" class="w-4 h-4"></i>
                Infografis Panduan
            </div>

            <img src="/uploads/panduan/<?= esc($panduan['file_media']) ?>"
                class="w-full rounded-2xl shadow-inner">

        <?php elseif ($panduan['tipe_media'] === 'audio' && !empty($panduan['file_media'])): ?>
            <div class="bg-gray-800 p-6 rounded-2xl text-center shadow-inner">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-gray-700 flex items-center justify-center">
                        <i data-lucide="mic" class="w-8 h-8 text-white"></i>
                    </div>
                </div>
                <audio controls class="w-full">
                    <source src="/uploads/panduan/<?= esc($panduan['file_media']) ?>" type="audio/mpeg">
                    Browser Anda tidak mendukung elemen audio.
                </audio>
            </div>
<?php elseif ($panduan['tipe_media'] === 'dokumen' && !empty($panduan['file_media'])): ?>
            <div class="mb-3 flex items-center gap-2 text-red-500 font-black text-xs uppercase tracking-wider">
                <i data-lucide="play-circle" class="w-4 h-4"></i>
                Pembelajaran
            </div>
            
            <div class="w-full rounded-2xl overflow-hidden shadow-inner bg-gray-100 mb-4">
                <iframe src="https://docs.google.com/gview?url=<?= urlencode(base_url('uploads/panduan/' . $panduan['file_media'])) ?>&embedded=true" class="w-full h-96 md:h-[600px]" frameborder="0"></iframe>
                
                </div>

            <div class="flex justify-center gap-3">
                <a href="<?= base_url('uploads/panduan/' . $panduan['file_media']) ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-blue-200 transition">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    Buka PDF
                </a>

                <a href="<?= base_url('uploads/panduan/' . $panduan['file_media']) ?>"
                    download="<?= esc($panduan['judul_panduan']) ?>.pdf"
                    class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-green-200 transition">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Unduh PDF
                </a>
            </div>
        <?php endif; ?>

        <div class="mt-6 pt-6 border-t border-gray-300">
            <h3 class="text-sm font-extrabold text-gray-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4 text-green-600"></i>
                Teks Panduan Lengkap
            </h3>
            <div class="prose text-gray-700 font-medium leading-relaxed text-sm md:text-base whitespace-pre-line text-justify">
                <?= $panduan['konten_panduan'] ? $panduan['konten_panduan'] : '<p class="text-gray-400 italic">Materi bacaan kosong.</p>' ?>
            </div>
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1 w-1/6"><i data-lucide="layout-dashboard" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span>
            </a>

            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="users" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span>
            </a>

            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"><i data-lucide="shield-alert" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span>
            </a>

            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-green-600 hover:text-green-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>

            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="file-bar-chart" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>

            <a href="/profil" class="flex flex-col items-center text-gray-400 transition transform hover:-translate-y-1 w-1/6 hover:text-blue-400"> <i data-lucide="user" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>

            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>


    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>