<?php

/**
 * @var array $modul
 * @var string $youtube_id
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($modul['judul_modul']) ?> - CyberGuard</title>
    <link rel="icon" type="image/png" href="logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
            background-color: #E0E5EC;
        }

        .neu-pressed {
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 rgba(255, 255, 255, 1);
            background-color: #E0E5EC;
        }

        .neu-btn-orange {
            background-color: #F97316;
            box-shadow: 4px 4px 8px rgba(249, 115, 22, 0.4), -4px -4px 8px rgba(255, 255, 255, 1);
        }

        .neu-btn-orange:active {
            box-shadow: inset 4px 4px 8px rgba(194, 65, 12, 0.6), inset -4px -4px 8px rgba(251, 146, 60, 0.5);
        }
    </style>
</head>

<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-20">

    <!-- Header -->
    <div class="p-6 flex items-center mb-2">
        <a href="/siswa/modul" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed flex-shrink-0">←</a>
        <h1 class="text-lg font-extrabold text-gray-800 ml-4 line-clamp-1"><?= esc($modul['judul_modul']) ?></h1>
    </div>

    <!-- Area Konten Utama -->
    <div class="px-6 flex-1 flex flex-col space-y-6">

        <!-- Area Render Multimedia Dinamis -->
        <?php if ($modul['tipe_media'] !== 'teks'): ?>
            <div class="neu-pressed p-2 rounded-3xl overflow-hidden w-full">

                <?php if ($modul['tipe_media'] === 'youtube' && !empty($youtube_id)): ?>
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/<?= $youtube_id ?>" frameborder="0" allowfullscreen></iframe>
                    </div>

                <?php elseif ($modul['tipe_media'] === 'gambar' && !empty($modul['file_media'])): ?>
                    <img src="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" alt="Ilustrasi" class="w-full h-auto max-h-[60vh] object-contain rounded-2xl">

                <?php elseif ($modul['tipe_media'] === 'audio' && !empty($modul['file_media'])): ?>
                    <div class="p-6 bg-gray-100 rounded-2xl flex flex-col items-center justify-center">
                        <span class="text-4xl mb-3">🎧</span>
                        <audio controls class="w-full max-w-md">
                            <source src="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" type="audio/mpeg">
                        </audio>
                    </div>

                <?php elseif ($modul['tipe_media'] === 'dokumen' && !empty($modul['file_media'])): ?>
                    <!-- Penampil PDF Disesuaikan (Tidak Over-Size di Laptop) -->
                    <div class="w-full h-[60vh] min-h-[400px] max-h-[600px] rounded-2xl overflow-hidden relative bg-gray-200 shadow-inner">
                        <iframe
                            src="https://docs.google.com/gview?url=<?= urlencode(base_url('uploads/modul/' . $modul['file_media'])) ?>&embedded=true"
                            class="w-full h-[60vh] md:h-[80vh] rounded-xl border border-gray-300"
                            frameborder="0">
                        </iframe>
                    </div>
                    <div class="mt-4 flex justify-center gap-3">

                        <!-- Tombol Buka PDF -->
                        <a href="<?= base_url('uploads/modul/' . $modul['file_media']) ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-blue-200 transition">
                            <i data-lucide="external-link" class="w-4 h-4"></i>
                            Buka PDF
                        </a>

                        <!-- Tombol Unduh PDF -->
                        <a href="<?= base_url('uploads/modul/' . $modul['file_media']) ?>"
                            download="<?= esc($modul['judul_modul']) ?>.pdf"
                            class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold shadow hover:bg-green-200 transition">
                            <i data-lucide="download" class="w-4 h-4"></i>
                            Unduh PDF
                        </a>

                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Teks Penjelasan / Materi -->
        <div class="neu-flat p-6 rounded-3xl">
            <!-- nl2br digunakan agar enter/baris baru dari database dirender sebagai <br> di HTML -->
            <p class="text-sm leading-relaxed text-gray-700 font-medium">
                <?= nl2br(($modul['konten_materi'])) ?>
            </p>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <a href="/siswa/modul/kuis/<?= $modul['id_modul'] ?>" class="neu-btn-orange text-center w-full text-white font-bold py-4 rounded-2xl transition duration-300 block mt-6">
            Selesai Membaca, Lanjut ke Kuis!
        </a>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">

            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span> </a>

            <a href="/siswa/modul" class="flex flex-col items-center text-teal-600 hover:text-teal-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span> </a>

            <a href="/siswa/simulasi" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span> </a>

            <a href="/siswa/jurnal" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="notebook-pen" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span> </a>

            <!-- Menu Profil (AKTIF - Menyala Biru) -->
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-400 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="user-round" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>

            <a href="/auth/logout" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span> </a>
        </div>
    </nav>

</body>

</html>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>