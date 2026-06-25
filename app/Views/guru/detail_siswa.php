<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekam Jejak Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }

        .neu-pressed {
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 #fff;
        }
    </style>
</head>

<body class="p-6 font-sans container mx-auto lg:max-w-4xl pb-28">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="neu-flat p-3 rounded-2xl">
                <i data-lucide="graduation-cap" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <h1 class="text-xl font-black text-gray-800">
                    Rekam Jejak Pembelajaran Siswa
                </h1>
                <p class="text-xs text-blue-600 font-bold">
                    <?= esc($siswa['nama_lengkap']) ?>
                    (Skor Mental Health: <?= $siswa['skor_kesejahteraan'] ?> Poin)
                </p>
            </div>
        </div>

        <a href="javascript:history.back()"
            class="neu-flat px-4 py-2 rounded-xl flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-blue-600 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="neu-flat p-5 rounded-3xl">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="book-open-check" class="w-5 h-5 text-blue-600"></i>
                <h3 class="font-bold text-xs text-gray-500 uppercase tracking-wider">
                    Evaluasi Nilai Modul Belajar
                </h3>
            </div>
            <div class="space-y-2">
                <?php foreach ($progres as $p): ?>
                    <div class="neu-pressed p-3 rounded-xl text-xs flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4 text-blue-500"></i>
                            <span class="font-bold"><?= esc($p['judul_modul']) ?></span>
                        </div>

                        <span class="font-black text-blue-600">
                            <?= $p['skor_kuis'] ?>%
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="neu-flat p-5 rounded-3xl">
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="brain-circuit" class="w-5 h-5 text-green-600"></i>
                <h3 class="font-bold text-xs text-gray-500 uppercase tracking-wider">
                    Respon Skenario Simulasi
                </h3>
            </div>
            <div class="space-y-2">
                <?php foreach ($simulasi as $s): ?>
                    <div class="neu-pressed p-3 rounded-xl text-xs flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-green-500"></i>
                            <span class="font-bold"><?= esc($s['judul_skenario']) ?></span>
                        </div>

                        <span class="font-black <?= $s['skor_kontrol_diri'] > 0 ? 'text-green-600' : 'text-red-500' ?>">
                            <?= $s['skor_kontrol_diri'] > 0 ? '+' : '' ?>
                            <?= $s['skor_kontrol_diri'] ?> Poin
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1 w-1/6"><i data-lucide="layout-dashboard" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span>
            </a>

            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-blue-600 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6">
                <i data-lucide="users" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span>
            </a>

            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"><i data-lucide="shield-alert" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span>
            </a>

            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-green-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>

            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="file-bar-chart" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>

            <!-- Menu Profil (AKTIF - Menyala Biru) -->
            <a href="/profil" class="flex flex-col items-center text-gray-400 transition transform hover:-translate-y-1 w-1/6 hover:text-blue-400"> <i data-lucide="user" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>

            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

</body>

</html>