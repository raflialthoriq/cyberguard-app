<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>

<body class="pb-28 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="neu-flat p-3 rounded-2xl">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>

            <div>
                <h1 class="text-2xl font-black text-gray-800">
                    <?= esc($kelas['nama_kelas']) ?>
                </h1>
                <p class="text-xs font-bold text-gray-500">
                    Daftar siswa bimbingan aktif di dalam rombel ini.
                </p>
            </div>
        </div>
        <a href="/guru/manajemen_kelas"
            class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500 flex items-center gap-2 hover:text-blue-600 transition"><i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

   <div class="neu-flat p-6 rounded-3xl overflow-x-auto border border-white/40">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-widest text-gray-400 border-b-2 border-gray-300">
                    <th class="py-3 px-4">Nama Lengkap</th>
                    <th class="hidden md:table-cell">Email</th>
                    <th class="py-3 px-4">Kesejahteraan</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($daftar_siswa as $s): ?>
                    <tr class="border-b border-gray-300/50 hover:bg-white/30 transition">
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i data-lucide="user" class="w-4 h-4 text-blue-600"></i>
                                </div>
                                <span class="font-bold text-gray-800">
                                    <?= esc($s['nama_lengkap']) ?>
                                </span>
                            </div>
                        </td>
                        <td class="hidden md:table-cell"><?= esc($s['email']) ?></td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="<?= $s['skor_kesejahteraan'] >= 50 ? 'heart-pulse' : 'heart-crack' ?>"
                                    class="w-4 h-4 <?= $s['skor_kesejahteraan'] >= 50 ? 'text-green-600' : 'text-red-500' ?>">
                                </i>

                                <span class="font-black <?= $s['skor_kesejahteraan'] >= 50 ? 'text-green-600' : 'text-red-500' ?>">
                                    <?= $s['skor_kesejahteraan'] ?> Poin
                                </span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <a href="/guru/detail_siswa/<?= $s['id_pengguna'] ?>"
                                class="inline-flex items-center gap-1 bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-200 transition shadow-sm border border-blue-200"><i data-lucide="activity" class="w-3.5 h-3.5"></i>
                                Aktivitas
                            </a>
                            <a href="<?= base_url('guru/keluarkan_siswa/' . $s['id_pengguna'] . '/' . $kelas['id_kelas']) ?>"
                                onclick="return confirm('Apakah Anda yakin ingin mengeluarkan <?= esc($s['nama_lengkap']) ?> dari kelas <?= esc($kelas['nama_kelas']) ?>?');"
                                class="inline-flex items-center gap-1 bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-200 transition shadow-sm border border-red-200"><i data-lucide="user-minus" class="w-3.5 h-3.5"></i>
                                Keluarkan
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($daftar_siswa)): ?>
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i data-lucide="users-round" class="w-12 h-12 text-gray-300"></i>

                                <div>
                                    <p class="font-bold text-gray-500">
                                        Belum ada siswa dalam kelas ini
                                    </p>

                                    <p class="text-xs text-gray-400 mt-1">
                                        Bagikan kode kelas kepada siswa untuk bergabung.
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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