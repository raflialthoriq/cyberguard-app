<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan: <?= esc($kuesioner['judul_kuesioner'] ?? 'Kuesioner') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/png" href="logo.png">
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }

        .neu-pressed {
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 rgba(255, 255, 255, 1);
        }
    </style>
</head>

<!-- ============================================================== -->
<!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
<!-- ============================================================== -->
<nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
    <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">

        <a href="/admin/beranda" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1"> <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>

        <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>

        <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1"> <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

        <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-green-600"> <i data-lucide="clipboard-list" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>

        <!-- ================== MENU AKSES (DROPUP) ================== -->
        <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
            <i data-lucide="shield-check"
                class="w-5 h-5 md:w-6 md:h-6 mb-1 text-gray-400 group-hover:text-indigo-500"></i>

            <!-- Teks "Akses" dengan Ikon Panah Ke Atas -->
            <span class="text-[9px] md:text-[10px] font-bold truncate w-full text-gray-400 group-hover:text-indigo-500 flex items-center justify-center gap-0.5">
                Akses
                <svg class="w-2.5 h-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path>
                </svg>
            </span>

            <!-- Popup Melayang -->
            <div id="menuAkses" class="hidden absolute bottom-full left-1/2 transform -translate-x-1/2 mb-3 bg-white rounded-2xl shadow-xl border border-gray-200 w-36 py-2 flex flex-col z-50 transition-all">
                <!-- Segitiga penunjuk ke bawah -->
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-white rotate-45 border-b border-r border-gray-200"></div>

                <a href="/admin/kelola_sekolah" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-green-600 hover:bg-green-50 transition border-b border-gray-100">
                    <i data-lucide="school" class="w-4 h-4 mr-3"></i> Sekolah
                </a>
                <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                    <i data-lucide="users" class="w-4 h-4 mr-3"></i> Pengguna
                </a>
                <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                    <i data-lucide="lightbulb" class="w-4 h-4 mr-3"></i> Afirmasi
                </a>
                <a href="/admin/kelola_panduan" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                    <i data-lucide="book" class="w-4 h-4 mr-3"></i> Panduan
                </a>
            </div>
        </div>
        <!-- ========================================================= -->

        <a href="/admin/ekspor_riset" class="flex-1 flex flex-col items-center text-gray-400 hover:text-purple-600 transition transform hover:-translate-y-1"> <i data-lucide="download" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Ekspor</span> </a>

        <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <i data-lucide="user" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>

        <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
            <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
            <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
        </a>
    </div>
</nav>

<!-- Script agar menu dropup tertutup otomatis jika area lain di layar diklik -->
<script>
    document.addEventListener('click', function(event) {
        const menuAkses = document.getElementById('menuAkses');
        if (menuAkses && !menuAkses.classList.contains('hidden')) {
            menuAkses.classList.add('hidden');
        }
    });
</script>

<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-6xl min-h-screen pt-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-7 h-7 text-purple-600"></i>
                Laporan Kuesioner
            </h1>
            <p class="text-sm font-bold text-purple-600 mt-1"><?= esc($kuesioner['judul_kuesioner'] ?? '') ?></p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="/admin/kelola_kuesioner"
                class="neu-flat px-4 py-2.5 rounded-xl text-xs font-bold text-gray-500 hover:text-gray-800 transition flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali
            </a>

            <?php if (isset($kuesioner['id_kuesioner'])): ?>
                <a href="<?= base_url('admin/ekspor_kuesioner/' . $kuesioner['id_kuesioner'] . '/csv') ?>"
                    class="bg-gray-800 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-gray-700 transition flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>Unduh CSV</span>
                </a>
                <a href="<?= base_url('admin/ekspor_kuesioner/' . $kuesioner['id_kuesioner'] . '/excel') ?>"
                    class="bg-green-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-green-700 transition flex items-center gap-2">
                    <i data-lucide="sheet" class="w-4 h-4"></i>
                    <span>Unduh Excel</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="neu-flat p-6 rounded-3xl mb-8">
        <h2 class="font-extrabold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">
            Rekapitulasi Data (<?= count($laporan ?? []) ?> Partisipan)
        </h2>

        <div class="overflow-x-auto pb-4">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-xs uppercase tracking-widest text-gray-500 border-b-2 border-gray-300">
                        <th class="py-3 px-4 font-extrabold w-10 text-center">No</th>
                        <th class="py-3 px-4 font-extrabold">Nama Siswa <span class="text-[9px] text-red-400 lowercase block">(Inisial Privasi)</span></th>
                        <th class="py-3 px-4 font-extrabold">Asal Sekolah</th>
                        <th class="py-3 px-4 font-extrabold">Tanggal Isi</th>

                        <?php if (isset($daftar_soal)): ?>
                            <?php foreach ($daftar_soal as $index => $soal): ?>
                                <th class="py-3 px-4 font-extrabold text-center bg-gray-50/50 cursor-help" title="<?= esc($soal['teks_soal'] ?? $soal['pertanyaan'] ?? 'Detail Soal ' . ($index + 1)) ?>">
                                    Soal <?= $index + 1 ?>
                                </th>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <th class="py-3 px-4 font-extrabold text-center sticky right-0 bg-[#E0E5EC] shadow-[-5px_0_10px_-5px_rgba(0,0,0,0.1)]">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($laporan)): ?>
                        <tr>
                            <td colspan="<?= (isset($daftar_soal) ? count($daftar_soal) : 0) + 5 ?>" class="py-12 text-center font-bold text-gray-400">
                                Belum ada siswa yang mengisi kuesioner ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1;
                        foreach ($laporan as $row): ?>
                            <tr class="border-b border-gray-300/50 hover:bg-white/30 transition">
                                <td class="py-3 px-4 text-center text-gray-500 font-bold"><?= $no++ ?></td>

                                <?php
                                $pecah_nama = explode(' ', trim($row['nama']));
                                $inisial = '';
                                foreach ($pecah_nama as $kata) {
                                    $inisial .= strtoupper(substr($kata, 0, 1));
                                }
                                ?>
                                <td class="py-3 px-4 font-black text-blue-600 tracking-wider">
                                    <?= esc($inisial) ?>
                                </td>

                                <td class="py-3 px-4 text-xs font-bold text-gray-600"><?= esc($row['asal_sekolah']) ?></td>
                                <td class="py-3 px-4 text-xs text-gray-500"><?= esc($row['tanggal_isi']) ?></td>

                                <?php if (isset($row['jawaban_bobot'])): ?>
                                    <?php foreach ($row['jawaban_bobot'] as $bobot): ?>
                                        <td class="py-3 px-4 text-center font-black <?= $bobot > 0 ? 'text-gray-800' : 'text-gray-300' ?> bg-white/20">
                                            <?= $bobot ?>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <td class="py-3 px-4 text-center sticky right-0 bg-[#E0E5EC] shadow-[-5px_0_10px_-5px_rgba(0,0,0,0.1)]">
                                    <a href="/admin/detail_jawaban_kuesioner/<?= $row['id_partisipasi'] ?>"
                                        class="inline-flex items-center gap-1.5 bg-purple-500 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-purple-600 shadow-sm transition active:scale-95">
                                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>