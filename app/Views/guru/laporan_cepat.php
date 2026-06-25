<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi</title>
    <link rel="icon" type="image/png" href="logo.png">
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

<body class="pb-36 font-sans container mx-auto px-4 lg:max-w-6xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="neu-flat p-3 rounded-2xl">
                <i data-lucide="file-bar-chart-2" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-800">
                    Laporan & Evaluasi
                </h1>
                <p class="text-xs text-gray-500 font-bold mt-1">
                    Sajian data analitik akurat berdasarkan relasi bimbingan kelas Anda.
                </p>
            </div>
        </div>
    </div>

    <div class="neu-flat p-6 rounded-3xl mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <select name="kelas" class="neu-pressed px-4 py-2 rounded-xl text-xs font-bold text-gray-700 outline-none">
                <option value="">Semua Kelas</option>
                <?php foreach ($daftar_kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= $filter_kelas == $k['id_kelas'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="month" name="waktu" value="<?= esc($filter_waktu) ?>" class="neu-pressed px-4 py-2 rounded-xl text-xs font-bold text-gray-700 outline-none">
            <button type="submit"
                class="bg-blue-600 text-white font-bold px-4 py-2 rounded-xl text-xs shadow hover:bg-blue-700 flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4"></i>
                Filter Data
            </button>
        </form>

        <div class="flex gap-2 w-full md:w-auto">
            <a href="/guru/ekspor_laporan/pdf" target="_blank"
                class="flex-1 flex items-center justify-center gap-2 bg-red-100 text-red-600 font-black px-4 py-2 rounded-xl text-xs border border-red-200">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                PDF
            </a>
            <a href="/guru/ekspor_laporan/excel"
                class="flex-1 flex items-center justify-center gap-2 bg-green-100 text-green-700 font-black px-4 py-2 rounded-xl text-xs border border-green-200">
                <i data-lucide="sheet" class="w-4 h-4"></i>
                Excel
            </a>
            <a href="/guru/ekspor_laporan/csv"
                class="flex-1 flex items-center justify-center gap-2 bg-gray-200 text-gray-700 font-black px-4 py-2 rounded-xl text-xs border border-gray-300">
                <i data-lucide="database" class="w-4 h-4"></i>
                CSV
            </a>
        </div>
    </div>

    <div class="neu-flat p-6 rounded-3xl overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b-2 border-gray-300">
                    <th class="py-3 px-3">
                        <div class="flex items-center gap-1">
                            <i data-lucide="user-round" class="w-3 h-3"></i>
                            Nama Siswa
                        </div>
                    </th>

                    <th class="py-3 px-3">
                        <div class="flex items-center gap-1">
                            <i data-lucide="heart-pulse" class="w-3 h-3"></i>
                            Kesejahteraan
                        </div>
                    </th>

                    <th class="py-3 px-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <i data-lucide="graduation-cap" class="w-3 h-3"></i>
                            Modul Tuntas
                        </div>
                    </th>

                    <th class="py-3 px-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <i data-lucide="brain" class="w-3 h-3"></i>
                            Nilai CBT
                        </div>
                    </th>

                    <th class="py-3 px-3">
                        <div class="flex items-center gap-1">
                            <i data-lucide="clock-3" class="w-3 h-3"></i>
                            Login Terakhir
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($laporan as $s): ?>
                    <tr class="border-b border-gray-300/40 hover:bg-white/30 transition">
                        <td class="py-4 px-3">
                            <p class="font-black text-gray-800 text-xs"><?= esc($s['nama']) ?></p>
                            <p class="text-[9px] font-bold text-gray-500"><?= esc($s['email']) ?></p>
                        </td>
                        <td class="py-4 px-3"><span class="inline-flex items-center gap-1 font-black <?= $s['skor_mental'] >= 50 ? 'text-green-500' : 'text-red-500' ?>">
                                <i data-lucide="<?= $s['skor_mental'] >= 50 ? 'shield-check' : 'shield-alert' ?>" class="w-3 h-3"></i>
                                <?= $s['skor_mental'] ?> Poin
                            </span></td>
                        <td class="py-4 px-3 text-center text-xs font-bold text-gray-700"><?= $s['modul_selesai'] ?> Bab <span class="text-blue-500">(Avg: <?= $s['rata_kuis'] ?>%)</span></td>
                        <td class="py-4 px-3 text-center text-xs font-black text-indigo-600"><?= $s['poin_cbt'] ?> Poin</td>
                        <td class="py-4 px-3 text-[10px] font-bold text-gray-500"><?= $s['login_terakhir'] ? date('d M Y, H:i', strtotime($s['login_terakhir'])) : 'Belum' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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

            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-green-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>

            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-purple-600 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <i data-lucide="file-bar-chart" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
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
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>

</html>