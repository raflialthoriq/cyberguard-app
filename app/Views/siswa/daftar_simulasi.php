<?php

/**
 * @var array $daftar_simulasi
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Simulasi - CyberGuard</title>
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

        .neu-btn-orange:hover {
            transform: translateY(-2px);
        }

        .card-simulasi {
            transition: all .25s ease;
        }

        .card-simulasi:hover {
            transform: translateY(-3px);
        }

        .neu-btn-orange {
            background: linear-gradient(135deg, #FB923C, #F97316);
            box-shadow:
                5px 5px 10px rgba(249, 115, 22, 0.35),
                -4px -4px 10px rgba(255, 255, 255, 0.8);
        }

        .neu-btn-orange:active {
            transform: scale(0.96);
        }
    </style>
</head>

<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-28">

    <div class="px-6 pt-8 pb-6">
        <div class="neu-flat rounded-3xl p-5 flex items-center">
            <a href="/siswa/beranda" class="neu-flat w-11 h-11 rounded-2xl flex items-center justify-center text-orange-600 font-extrabold active:neu-pressed mr-4 transition-transform hover:scale-95">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </a>
            <div>
                <p class="text-[10px] uppercase tracking-[0.25em] text-gray-400 font-bold">
                    CyberGuard
                </p>
                <h1 class="text-xl font-black text-gray-700">
                    Simulasi CBT
                </h1>
            </div>
        </div>
    </div>

    <div class="px-6 flex-1 pb-10">

        <?php if (session()->getFlashdata('pesan_sukses')): ?>
            <div class="neu-flat bg-green-50 text-green-700 p-5 rounded-3xl mb-6 border-l-4 border-green-500 font-bold">
                <?= session()->getFlashdata('pesan_sukses') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('pesan_gagal')): ?>
            <div class="neu-flat bg-red-50 text-red-700 p-5 rounded-3xl mb-6 border-l-4 border-red-500 font-bold">
                <?= session()->getFlashdata('pesan_gagal') ?>
            </div>
        <?php endif; ?>

        <div class="space-y-6">
            <?php if (empty($daftar_simulasi)): ?>
                <div class="neu-flat p-8 rounded-3xl text-center">
                    <div class="text-5xl mb-3"><i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i></div>
                    <p class="font-extrabold text-gray-700 text-lg">
                        Belum Ada Simulasi
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Simulasi CBT akan tersedia setelah administrator menambahkannya.
                    </p>
                </div>
            <?php else: ?>
                <?php foreach ($daftar_simulasi as $index => $simulasi): ?>
                    <div class="neu-flat card-simulasi p-5 rounded-3xl">
                        <div class="flex items-center">
                            <div class="w-14 h-14 rounded-2xl neu-pressed flex items-center justify-center text-2xl flex-shrink-0 mr-4">
                                <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] uppercase tracking-widest font-extrabold text-orange-500 mb-1">
                                    Skenario <?= $index + 1 ?>
                                </p>
                                <h2 class="text-sm md:text-base font-extrabold text-gray-700 leading-snug">
                                    <?= esc($simulasi['judul_simulasi']) ?>
                                </h2>
                            </div>
                            <a href="/siswa/simulasi/main/<?= $simulasi['id_skenario'] ?>"
                                <?php
                                $is_selesai = isset($simulasi['status']) && $simulasi['status'] === 'selesai';
                                $bg_color = $is_selesai
                                    ? 'bg-green-100 text-green-600'
                                    : 'bg-orange-100 text-orange-500';
                                ?>

                                <a href="/siswa/simulasi/main/<?= $simulasi['id_skenario'] ?>"
                                class="mt-3 inline-flex items-center gap-2 px-4 py-2 rounded-lg font-semibold text-sm <?= $bg_color ?> transition-all hover:scale-105">

                                <?php if ($is_selesai): ?>
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    Lihat Hasil
                                <?php else: ?>
                                    <i data-lucide="play-circle" class="w-4 h-4"></i>
                                    Mulai
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">

            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span>
            </a>

            <a href="/siswa/modul" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span>
            </a>

            <a href="/siswa/simulasi" class="flex flex-col items-center text-orange-600 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span>
            </a>

            <a href="/siswa/jurnal" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="notebook-pen" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span>
            </a>

            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-400 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="user-round" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span>
            </a>

            <a href="/auth/logout" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6">
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