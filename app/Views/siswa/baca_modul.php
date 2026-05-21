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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-orange { background-color: #F97316; box-shadow: 4px 4px 8px rgba(249, 115, 22, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-orange:active { box-shadow: inset 4px 4px 8px rgba(194, 65, 12, 0.6), inset -4px -4px 8px rgba(251, 146, 60, 0.5); }
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
        <?php if($modul['tipe_media'] !== 'teks'): ?>
            <div class="neu-pressed p-2 rounded-3xl overflow-hidden w-full">
                
                <?php if($modul['tipe_media'] === 'youtube' && !empty($youtube_id)): ?>
                    <div class="relative w-full aspect-video rounded-2xl overflow-hidden">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/<?= $youtube_id ?>" frameborder="0" allowfullscreen></iframe>
                    </div>

                <?php elseif($modul['tipe_media'] === 'gambar' && !empty($modul['file_media'])): ?>
                    <img src="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" alt="Ilustrasi" class="w-full h-auto max-h-[60vh] object-contain rounded-2xl">

                <?php elseif($modul['tipe_media'] === 'audio' && !empty($modul['file_media'])): ?>
                    <div class="p-6 bg-gray-100 rounded-2xl flex flex-col items-center justify-center">
                        <span class="text-4xl mb-3">🎧</span>
                        <audio controls class="w-full max-w-md">
                            <source src="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" type="audio/mpeg">
                        </audio>
                    </div>

                <?php elseif($modul['tipe_media'] === 'dokumen' && !empty($modul['file_media'])): ?>
                    <!-- Penampil PDF Disesuaikan (Tidak Over-Size di Laptop) -->
                    <div class="w-full h-[60vh] min-h-[400px] max-h-[600px] rounded-2xl overflow-hidden relative bg-gray-200 shadow-inner">
                        <iframe src="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" class="absolute top-0 left-0 w-full h-full border-0"></iframe>
                    </div>
                    <div class="text-center mt-4">
                        <a href="<?= base_url('uploads/modul/' . esc($modul['file_media'])) ?>" download class="neu-flat px-6 py-2 rounded-full text-blue-600 font-bold text-xs inline-block active:neu-pressed">⬇️ Unduh PDF ke Perangkat</a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

        <!-- Teks Penjelasan / Materi -->
        <div class="neu-flat p-6 rounded-3xl">
            <!-- nl2br digunakan agar enter/baris baru dari database dirender sebagai <br> di HTML -->
            <p class="text-sm leading-relaxed text-gray-700 font-medium">
                <?= nl2br(esc($modul['konten_materi'])) ?>
            </p>
        </div>

        <!-- Spacer -->
        <div class="flex-1"></div>

        <a href="/siswa/modul/kuis/<?= $modul['id_modul'] ?>" class="neu-btn-orange text-center w-full text-white font-bold py-4 rounded-2xl transition duration-300 block mt-6">
            Selesai Membaca, Lanjut ke Kuis!
        </a>

    </div>

</body>
</html>