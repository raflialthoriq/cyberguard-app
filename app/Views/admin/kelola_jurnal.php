<?php /** @var array $daftar_jurnal */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantau Jurnal - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="p-6 font-sans text-gray-700 min-h-screen flex flex-col">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">Pemantauan Jurnal Siswa</h1>
            <p class="text-sm font-medium text-gray-500">Hasil Dekripsi AES-256 untuk Konseling BK</p>
        </div>
        <a href="/auth/logout" class="text-red-500 font-bold text-sm px-5 py-2 neu-flat rounded-full active:neu-pressed">Logout</a>
    </div>

    <!-- Menu Navigasi Manajemen -->
    <!-- Menu Navigasi Admin / Peneliti -->
    <div class="flex overflow-x-auto hide-scrollbar gap-3 mb-8 pb-2">
        <a href="/admin/beranda" class="flex-shrink-0 px-5 py-3 rounded-full font-bold text-sm transition <?= current_url() == site_url('admin/beranda') ? 'neu-pressed text-blue-600' : 'neu-flat text-gray-500 hover:text-blue-500' ?>">🏠 Beranda Admin</a>
        
        <a href="/admin/kelola_modul" class="flex-shrink-0 px-5 py-3 rounded-full font-bold text-sm transition <?= current_url() == site_url('admin/kelola_modul') ? 'neu-pressed text-teal-600' : 'neu-flat text-gray-500 hover:text-teal-500' ?>">📚 CMS Modul</a>
        
        <a href="/admin/kelola_simulasi" class="flex-shrink-0 px-5 py-3 rounded-full font-bold text-sm transition <?= current_url() == site_url('admin/kelola_simulasi') ? 'neu-pressed text-orange-500' : 'neu-flat text-gray-500 hover:text-orange-500' ?>">🎮 CMS Simulasi</a>
        
        <a href="/admin/kelola_sekolah" class="flex-shrink-0 px-5 py-3 rounded-full font-bold text-sm transition <?= current_url() == site_url('admin/kelola_sekolah') ? 'neu-pressed text-green-600' : 'neu-flat text-gray-500 hover:text-green-500' ?>">🏫 Master Sekolah</a>

        <a href="/admin/ekspor_riset" class="flex-shrink-0 px-5 py-3 rounded-full font-bold text-sm transition <?= current_url() == site_url('admin/ekspor_riset') ? 'neu-pressed text-purple-600' : 'neu-flat text-gray-500 hover:text-purple-500' ?>">📥 Ekspor Data (CSV)</a>
    </div>
    <!-- Daftar Jurnal -->
    <div class="space-y-6 pb-10">
        <?php if(empty($daftar_jurnal)): ?>
            <div class="neu-pressed p-8 rounded-3xl text-center text-gray-500 font-bold">
                Belum ada entri jurnal yang masuk dari siswa.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach($daftar_jurnal as $jurnal): ?>
                    <div class="neu-flat p-6 rounded-3xl flex flex-col relative overflow-hidden">
                        
                        <!-- Pita Warna Status Emosi -->
                        <div class="absolute top-0 left-0 w-2 h-full <?= strpos($jurnal['suasana_hati'], 'sedih') !== false || strpos($jurnal['suasana_hati'], 'marah') !== false || strpos($jurnal['suasana_hati'], 'cemas') !== false ? 'bg-red-400' : 'bg-green-400' ?>"></div>
                        
                        <div class="flex justify-between items-center mb-4 pl-4 border-b pb-3">
                            <div>
                                <h2 class="font-bold text-gray-800 text-lg"><?= esc($jurnal['nama_lengkap']) ?></h2>
                                <p class="text-xs text-gray-500"><?= date('d F Y', strtotime($jurnal['tanggal_jurnal'])) ?></p>
                            </div>
                            <div class="neu-pressed px-4 py-2 rounded-xl text-sm font-bold">
                                <?= $jurnal['ikon_mood'] ?>
                            </div>
                        </div>
                        
                        <div class="pl-4 flex-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Isi Jurnal (Telah Didekripsi):</p>
                            <div class="neu-pressed p-4 rounded-2xl text-sm text-gray-700 leading-relaxed italic">
                                "<?= esc($jurnal['teks_asli']) ?>"
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>