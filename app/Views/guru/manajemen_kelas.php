<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex flex-col items-center text-gray-400 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📊</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-blue-600 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">👥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚨</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📄</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

<body class="pb-28 p-4 p-6 font-sans text-gray-700 min-h-screen flex flex-col relative">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Manajemen Kelas 👥</h1>
            <p class="text-sm font-bold text-gray-500 mt-1">Pantau progres psikoedukasi siswa berdasarkan kelas.</p>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 text-sm font-bold neu-flat border-l-4 border-green-500">
            ✅ <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <!-- Form Buat Kelas Baru -->
    <div class="neu-flat p-6 rounded-3xl mb-8">
        <h2 class="font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2 flex items-center">
            ➕ Buat Kelas Baru
        </h2>
        <form action="/guru/simpan_kelas" method="POST" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="nama_kelas" placeholder="Nama Kelas (Contoh: XII IPA 1)" class="neu-pressed flex-1 px-5 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700" required>
            <button type="submit" class="bg-teal-600 text-white font-bold py-3 px-8 rounded-xl transition duration-300 shadow-lg hover:bg-teal-700 active:scale-95 text-sm">
                Simpan Kelas
            </button>
        </form>
    </div>
<!-- Daftar Kelas -->
    <div class="space-y-5">
        <?php if(empty($daftar_kelas)): ?>
            <div class="neu-pressed p-8 rounded-3xl text-center text-gray-500 font-bold">
                Belum ada kelas yang dibuat. Silakan buat kelas pertama Anda di atas.
            </div>
        <?php else: ?>
            <?php foreach($daftar_kelas as $kelas): ?>
                <div class="neu-pressed p-5 rounded-3xl">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="font-extrabold text-gray-800 text-lg"><?= esc($kelas['nama_kelas']) ?></h3>
                            <!-- Menampilkan Kode Kelas untuk di-share ke siswa -->
                            <p class="text-xs text-teal-600 font-bold mt-1 bg-teal-100 inline-block px-2 py-1 rounded tracking-widest">
                                KODE: <?= esc($kelas['kode_kelas']) ?>
                            </p>
                            <p class="text-xs font-bold text-gray-500 mt-2"><?= $kelas['jumlah_siswa'] ?> Siswa</p>
                        </div>
                        
                        <!-- Indikator Status -->
                        <div class="flex flex-col items-end">
                            <span class="text-xs font-bold <?= $kelas['status_warna'] ?> <?= $kelas['status_bg'] ?> px-3 py-1 rounded-full mb-1">
                                Status: <?= $kelas['status_teks'] ?>
                            </span>
                            <a href="#" class="text-xs font-bold text-blue-500 hover:underline">Lihat Detail ></a>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between text-xs font-bold text-gray-500 mb-1">
                            <span>Rata-rata Progres</span>
                            <span class="<?= $kelas['status_warna'] ?>"><?= $kelas['rata_progres'] ?>%</span>
                        </div>
                        <div class="w-full bg-gray-300 rounded-full h-2.5 neu-pressed overflow-hidden">
                            <div class="h-2.5 rounded-full <?= $kelas['rata_progres'] > 70 ? 'bg-green-500' : ($kelas['rata_progres'] >= 40 ? 'bg-yellow-500' : 'bg-red-500') ?>" style="width: <?= $kelas['rata_progres'] ?>%"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?> <!-- Ini penutup yang hilang tadi -->
    </div>

</body>
</html>