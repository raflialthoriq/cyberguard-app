<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jawaban Siswa</title>
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

<body class="pb-28 font-sans text-gray-700 container mx-auto px-4 lg:max-w-3xl min-h-screen pt-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                <i data-lucide="clipboard-check" class="w-7 h-7 text-purple-600"></i>
                Detail Jawaban
            </h1>
            <p class="text-sm font-bold text-gray-500 flex items-center gap-2 mt-1">
                <i data-lucide="user-round" class="w-4 h-4 text-blue-500"></i>
                <span class="text-blue-600"><?= esc($info['nama_lengkap']) ?></span>
            </p>
        </div>
        <a href="/admin/laporan_kuesioner/<?= $info['id_kuesioner'] ?>"
            class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500 hover:text-gray-800 flex items-center gap-2">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <div class="space-y-4">
        <?php $no = 1;
        foreach ($jawaban as $j): ?>
            <div class="neu-flat p-5 rounded-2xl">
                <p class="text-xs font-extrabold text-gray-500 mb-2 flex items-center gap-1">
                    <i data-lucide="hash" class="w-3 h-3"></i>
                    Soal <?= $no ?>
                </p>
                <h3 class="font-bold text-sm text-gray-800 mb-3"><?= esc($j['teks_soal']) ?></h3>
                <div class="neu-pressed px-4 py-3 rounded-xl border-l-4 border-purple-500 flex items-start gap-3">
                    <i data-lucide="message-square-text" class="w-5 h-5 text-purple-600 mt-0.5"></i>

                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-extrabold text-purple-500">
                            Jawaban Siswa
                        </p>
                        <p class="text-sm font-bold text-purple-700">
                            <?= esc($j['jawaban_teks']) ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php $no++;
        endforeach; ?>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>