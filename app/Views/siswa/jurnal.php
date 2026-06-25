<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Harian - CyberGuard</title>
    <link rel="icon" type="image/png" href="<?= base_url('logo.png') ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            background-color: #E0E5EC;
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }

        .neu-pressed {
            background-color: #E0E5EC;
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 rgba(255, 255, 255, 1);
        }

        .neu-btn-orange {
            background-color: #F97316;
            box-shadow: 6px 6px 10px rgba(249, 115, 22, 0.4), -6px -6px 10px rgba(255, 255, 255, 1);
        }

        .neu-btn-orange:active {
            box-shadow: inset 4px 4px 8px rgba(194, 65, 12, 0.6), inset -4px -4px 8px rgba(251, 146, 60, 0.5);
        }

        input[type="radio"] {
            display: none;
        }

        .mood-label {
            transition: all 0.2s ease;
        }

        input[type="radio"]:checked+.mood-label {
            box-shadow: inset 4px 4px 8px rgba(163, 177, 198, 0.7), inset -4px -4px 8px rgba(255, 255, 255, 1);
            transform: scale(0.95);
        }

        .neu-btn-purple {
            background: #8B5CF6;
            box-shadow:
                6px 6px 12px rgba(139, 92, 246, .35),
                -6px -6px 12px rgba(255, 255, 255, .9);
            transition: .2s;
        }

        .neu-btn-purple:hover {
            transform: translateY(-2px);
        }

        .neu-btn-purple:active {
            transform: scale(.98);
            box-shadow:
                inset 4px 4px 8px rgba(91, 33, 182, .45),
                inset -4px -4px 8px rgba(196, 181, 253, .5);
        }
    </style>
</head>

<nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
    <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
        <a href="<?= base_url('siswa/beranda') ?>" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
            <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span> </a>
        <a href="<?= base_url('siswa/modul') ?>" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span> </a>
        <a href="<?= base_url('siswa/simulasi') ?>" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span> </a>
        <a href="<?= base_url('siswa/jurnal') ?>" class="flex flex-col items-center text-purple-600 hover:text-purple-400 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="notebook-pen" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span> </a>
        <a href="<?= base_url('profil') ?>" class="flex flex-col items-center text-gray-400 hover:text-blue-400 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="user-round" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
        <a href="<?= base_url('auth/logout') ?>" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span> </a>
    </div>
</nav>

<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-28">

    <div class="p-6 flex items-center justify-between">
        <a href="<?= base_url('siswa/beranda') ?>">
        </a>
        <h1 class="text-lg font-extrabold text-gray-700 uppercase tracking-wider flex items-center gap-2">
            <i data-lucide="notebook-pen" class="w-5 h-5 text-purple-600"></i>
            Jurnal Harian
        </h1>
        <div class="w-10"></div>
    </div>

    <div class="flex-1 px-6 pb-6 flex flex-col max-w-3xl mx-auto w-full">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="neu-pressed text-green-600 font-semibold p-4 rounded-2xl mb-6 text-center border-l-4 border-green-500">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('siswa/simpan_jurnal') ?>" method="POST" class="flex flex-col mb-10">
            <div class="text-center mb-8 neu-flat p-6 rounded-[32px] border-t-4 border-purple-400">
                <h2 class="text-lg font-bold text-gray-700 mb-6 flex items-center justify-center gap-2">
                    <i data-lucide="heart" class="w-5 h-5 text-pink-500 fill-pink-500"></i>
                    Bagaimana perasaanmu hari ini? <span class="text-xs text-gray-400 font-normal ml-1"></span>
                </h2>

                <div class="flex justify-center space-x-6">
                    <div>
                        <input type="radio" id="mood_sedih" name="suasana_hati" value="sedih">
                        <label for="mood_sedih" class="mood-label neu-flat cursor-pointer w-16 h-16 flex items-center justify-center rounded-full">
                            <i data-lucide="frown" class="w-8 h-8 text-red-500"></i>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="mood_biasa" name="suasana_hati" value="biasa">
                        <label for="mood_biasa" class="mood-label neu-flat cursor-pointer w-16 h-16 flex items-center justify-center rounded-full">
                            <i data-lucide="meh" class="w-8 h-8 text-yellow-500"></i>
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="mood_senang" name="suasana_hati" value="senang">
                        <label for="mood_senang" class="mood-label neu-flat cursor-pointer w-16 h-16 flex items-center justify-center rounded-full">
                            <i data-lucide="smile" class="w-8 h-8 text-green-500"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col mb-6 min-h-[200px]">
                <textarea
                    name="teks_jurnal"
                    class="neu-pressed w-full flex-1 p-6 rounded-3xl focus:outline-none focus:ring-2 focus:ring-purple-300 text-gray-700 resize-none transition"
                    placeholder="Tulis catatan harianmu di sini..."
                    required></textarea>
                <p class="text-xs text-gray-400 mt-4 text-center font-semibold flex items-center justify-center gap-1">
                    <i data-lucide="shield-check" class="w-4 h-4 text-green-600"></i>
                    Catatanmu dienkripsi dan aman tanpa diketahui pihak lain.
                </p>
            </div>

            <button type="submit"
                class="neu-btn-purple w-full text-white font-bold py-4 rounded-2xl flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Jurnal
            </button>
        </form>

        <hr class="border-gray-300 mb-8" style="box-shadow: 0 1px 1px rgba(255,255,255,0.7);">

        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xs md:text-sm font-extrabold text-gray-700 uppercase tracking-wider flex items-center gap-2">
                <i data-lucide="history" class="w-5 h-5 text-blue-500"></i>
                Catatan Sebelumnya
            </h3>

            <div class="relative inline-block text-left">
                <form action="<?= base_url('siswa/jurnal') ?>" method="GET" id="filter-limit-form">
                    <select name="limit" onchange="document.getElementById('filter-limit-form').submit();"
                        class="neu-flat text-[11px] font-extrabold text-gray-600 rounded-xl pl-3 pr-8 py-2 focus:outline-none cursor-pointer border border-white/40 appearance-none uppercase tracking-wider">
                        <option value="5" <?= (isset($current_limit) && $current_limit == 5) ? 'selected' : '' ?>>5 Catatan</option>
                        <option value="10" <?= (isset($current_limit) && $current_limit == 10) ? 'selected' : '' ?>>10 Catatan</option>
                        <option value="25" <?= (isset($current_limit) && $current_limit == 25) ? 'selected' : '' ?>>25 Catatan</option>
                        <option value="semua" <?= (isset($current_limit) && $current_limit == 'semua') ? 'selected' : '' ?>>Semua</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <i data-lucide="chevron-down" class="w-3 h-3"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <?php if (isset($riwayat_jurnal) && !empty($riwayat_jurnal)): ?>
                <?php foreach ($riwayat_jurnal as $jurnal): ?>
                    <div class="neu-flat p-6 rounded-3xl relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-2 bg-purple-400 rounded-l-3xl"></div>

                        <div class="flex items-center text-xs font-bold text-gray-400 mb-3 ml-2 uppercase tracking-wide">
                            <i data-lucide="calendar-clock" class="w-4 h-4 mr-2"></i>
                            <?= date('d M Y, H:i', strtotime($jurnal['tanggal_jurnal'])) ?> WIB

                            <?php if (!empty($jurnal['suasana_hati'])): ?>
                                <span class="mx-3 text-gray-300">|</span>
                                <?php
                                $moodColor = '';
                                $moodIcon = '';
                                if ($jurnal['suasana_hati'] == 'senang') {
                                    $moodColor = 'text-green-500';
                                    $moodIcon = 'smile';
                                } elseif ($jurnal['suasana_hati'] == 'biasa') {
                                    $moodColor = 'text-yellow-500';
                                    $moodIcon = 'meh';
                                } elseif ($jurnal['suasana_hati'] == 'sedih') {
                                    $moodColor = 'text-red-500';
                                    $moodIcon = 'frown';
                                }
                                ?>
                                <i data-lucide="<?= $moodIcon ?>" class="w-4 h-4 mr-1 <?= $moodColor ?>"></i>
                                <span class="capitalize <?= $moodColor ?>">Merasa <?= esc($jurnal['suasana_hati']) ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-gray-700 ml-2 leading-relaxed">
                            <?= nl2br(esc($jurnal['teks_jurnal'])) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="neu-pressed p-8 rounded-3xl text-center flex flex-col items-center justify-center text-gray-400">
                    <i data-lucide="inbox" class="w-10 h-10 mb-3 opacity-50"></i>
                    <p class="font-semibold text-sm">Belum ada catatan jurnal.</p>
                    <p class="text-xs mt-1">Mulai tulis ceritamu hari ini!</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

</html>