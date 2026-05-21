<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru BK - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom colors untuk status progress */
        .status-good { width: 100%; background-color: #10B981; } /* Hijau > 70% */
        .status-warning { width: 100%; background-color: #F59E0B; } /* Kuning 40-70% */
        .status-critical { width: 100%; background-color: #EF4444; } /* Merah < 40% */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 pb-20 font-sans">

    <!-- Header Sapaan -->
    <div class="bg-white p-6 rounded-b-3xl shadow-sm mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Selamat Datang,</h1>
                <h2 class="text-2xl font-bold text-blue-600">Bpk/Ibu <?= esc($nama_lengkap) ?></h2>
                <p class="text-xs text-gray-400 mt-1">Sistem Monitoring Agregat & Anonim</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 font-bold text-xl">
                <?= strtoupper(substr($nama_lengkap, 0, 1)) ?>
            </div>
        </div>

        <!-- Card Grid Statistik (M9) -->
        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="bg-blue-50 p-3 rounded-xl border border-blue-100">
                <p class="text-2xl font-bold text-blue-800"><?= $total_siswa ?></p>
                <p class="text-xs text-blue-600 font-semibold mt-1">Siswa Aktif</p>
            </div>
            <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                <p class="text-2xl font-bold text-green-800"><?= $rata_progres ?>%</p>
                <p class="text-xs text-green-600 font-semibold mt-1">Rata-rata Progres</p>
            </div>
            <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                <p class="text-2xl font-bold text-red-800"><?= $siswa_perhatian ?></p>
                <p class="text-xs text-red-600 font-semibold mt-1">Perlu Perhatian</p>
            </div>
        </div>
    </div>

    <div class="px-6 space-y-6">
        
        <!-- Section Notifikasi Intervensi Dini / Alert (E15) -->
        <div>
            <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                <span class="bg-red-500 w-2 h-4 rounded mr-2"></span> Modul Intervensi Dini
            </h3>
            
            <div class="space-y-3">
                <?php foreach($daftar_alert as $alert): ?>
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 <?= $alert['level'] == 'high' ? 'border-red-500' : 'border-orange-400' ?> flex items-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 mr-4">
                        <?= esc($alert['inisial']) ?>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800">Siswa <?= esc($alert['inisial']) ?></p>
                        <p class="text-xs text-gray-500">Alasan: <?= esc($alert['alasan']) ?></p>
                    </div>
                    <button class="bg-blue-50 text-blue-600 text-xs px-3 py-1 rounded-full font-semibold">Tinjau</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Section Daftar Kelas (D10) -->
        <div>
            <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                <span class="bg-blue-500 w-2 h-4 rounded mr-2"></span> Manajemen Kelas
            </h3>
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <?php foreach($daftar_kelas as $kelas): ?>
                <div class="p-4 border-b last:border-0">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="font-bold text-sm text-gray-800"><?= esc($kelas['nama']) ?></p>
                            <p class="text-xs text-gray-500"><?= esc($kelas['jumlah_siswa']) ?> Siswa</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold <?= $kelas['progres'] < 40 ? 'text-red-500' : ($kelas['progres'] < 70 ? 'text-orange-500' : 'text-green-500') ?>">
                                <?= esc($kelas['progres']) ?>%
                            </p>
                            <p class="text-xs text-gray-400">Progres</p>
                        </div>
                    </div>
                    <!-- Mini Progress Bar -->
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full status-<?= esc($kelas['status']) ?>" style="width: <?= esc($kelas['progres']) ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="text-center mt-8">
             <a href="/auth/logout" class="text-red-500 underline text-sm">Keluar dari Panel Monitoring</a>
        </div>

    </div>

</body>
</html>