<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas - CyberGuard</title>
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

<body class="pb-36 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8">

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="neu-flat p-3 rounded-2xl">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                    Manajemen Ruang Kelas
                </h1>
                <p class="text-xs font-bold text-gray-500 mt-1">
                    Kontrol penuh validitas rute kode undangan bimbingan.
                </p>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="bg-white border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl mb-6 text-xs font-bold neu-flat text-center"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-extrabold text-sm text-gray-800 mb-4 uppercase tracking-wider border-b pb-2">Buat Kelas Baru</h2>
            <form action="/guru/simpan_kelas" method="POST">
                <input type="text" name="nama_kelas" placeholder="Contoh: XII-RPL-1" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-xs font-bold text-gray-700 mb-4" required>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-extrabold py-3 rounded-xl text-xs shadow-md transition active:scale-95 flex items-center justify-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Terbitkan Kelas
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-extrabold text-sm text-gray-800 mb-2 uppercase tracking-wider px-2">Daftar Kelas Bimbingan Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($daftar_kelas as $k): ?>
                    <div class="neu-flat p-5 rounded-3xl flex flex-col justify-between border border-white/40">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-black text-gray-800 text-base"><?= esc($k['nama_kelas']) ?></h3>
                                <div class="flex items-center gap-1 text-[10px] font-bold text-gray-400 mt-1">
                                    <i data-lucide="graduation-cap" class="w-3 h-3"></i>
                                    <span><?= $k['jumlah_siswa'] ?> Siswa</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded <?= $k['status_kelas'] == 'buka' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>"><?= $k['status_kelas'] ?></span>
                        </div>


                        <div class="my-4 neu-pressed p-3 rounded-2xl flex justify-between items-center bg-gray-50/10">
                            <span id="kode_<?= $k['id_kelas'] ?>" class="text-xs font-mono tracking-widest font-black text-blue-600"><?= esc($k['kode_kelas']) ?></span>
                            <div class="flex gap-1">
                                <button
                                    onclick="navigator.clipboard.writeText(document.getElementById('kode_<?= $k['id_kelas'] ?>').innerText); alert('Kode kelas <?= esc($k['nama_kelas']) ?> berhasil disalin!');"
                                    class="flex items-center gap-1 text-[9px] bg-white text-blue-600 px-2.5 py-1 rounded-lg font-bold shadow-sm border border-blue-200">

                                    <i data-lucide="copy" class="w-3 h-3"></i>

                                </button>

                                <?php if ($k['status_kelas'] == 'buka'): ?>
                                    <a href="/guru/refresh_kode_kelas/<?= $k['id_kelas'] ?>"
                                        class="flex items-center gap-1 text-[9px] bg-white text-gray-600 px-2 py-1 rounded-lg font-bold shadow-sm hover:bg-gray-100">

                                        <i data-lucide="refresh-cw" class="w-3 h-3"></i>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-3 pt-2 border-t border-gray-300/40">
                            <div class="flex justify-between text-[10px] font-bold">
                                <span class="text-gray-400">Rata-rata Progres:</span>
                                <?php
                                // LOGIKA WARNA STATUS KELAS
                                $warna_text = 'text-red-600';
                                $warna_bar = 'bg-red-500'; // Default < 40% (Merah)

                                if ($k['rata_progres'] > 70) {
                                    $warna_text = 'text-green-600';
                                    $warna_bar = 'bg-green-500'; // > 70% (Hijau)
                                } elseif ($k['rata_progres'] >= 40) {
                                    $warna_text = 'text-yellow-600';
                                    $warna_bar = 'bg-yellow-500'; // 40% - 70% (Kuning)
                                }
                                ?>
                                <span class="<?= $warna_text ?>"><?= $k['rata_progres'] ?>%</span>
                            </div>
                            <div class="w-full bg-gray-300 rounded-full h-1.5 overflow-hidden shadow-inner">
                                <div class="<?= $warna_bar ?> h-1.5 transition-all duration-500" style="width: <?= $k['rata_progres'] ?>%"></div>
                            </div>
                            <div class="flex gap-2 pt-1">
                                <a href="/guru/detail_kelas/<?= $k['id_kelas'] ?>"
                                    class="w-1/2 flex items-center justify-center gap-1 bg-blue-600 text-white font-bold py-2 rounded-xl text-[10px] shadow active:scale-95 transition"><i data-lucide="user-cog" class="w-3.5 h-3.5"></i>Kelola
                                </a>
                                <?php if ($k['status_kelas'] == 'buka'): ?>
                                    <a href="/guru/tutup_kelas/<?= $k['id_kelas'] ?>"
                                        class="w-1/2 flex items-center justify-center gap-1 text-[10px] font-bold py-2 rounded-xl border border-gray-400/50 text-red-600 bg-red-50/20 hover:bg-red-100 transition">

                                        <i data-lucide="lock" class="w-3.5 h-3.5"></i>
                                        Tutup
                                    </a>
                                <?php else: ?>
                                    <a href="/guru/tutup_kelas/<?= $k['id_kelas'] ?>"
                                        class="w-1/2 flex items-center justify-center gap-1 text-[10px] font-bold py-2 rounded-xl border border-gray-400/50 text-green-600 bg-green-50/20 hover:bg-green-100 transition">

                                        <i data-lucide="unlock" class="w-3.5 h-3.5"></i>
                                        Buka
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
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