<?php 
/** 
 * @var int $total_siswa 
 * @var int $total_modul 
 * @var float $rata_kuis 
 * @var array $progres_terbaru 
 * @var array $simulasi_terbaru 
 */ 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-blue-600"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
                <span class="text-xl md:text-2xl mb-1 grayscale group-hover:grayscale-0 transition transform group-hover:-translate-y-1 text-gray-400 group-hover:text-indigo-500">🔐</span>
                
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
                        <span class="mr-3 text-lg">🏫</span> Sekolah
                    </a>
                    <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">👥</span> Pengguna
                    </a>
                    <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">💡</span> Afirmasi
                    </a>
                </div>
            </div>
            <!-- ========================================================= -->
            
            <a href="/admin/ekspor_riset" class="flex-1 flex flex-col items-center text-gray-400 hover:text-purple-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Ekspor</span> </a>
            
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
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

<body class="p-6 font-sans text-gray-700 min-h-screen flex flex-col pb-28">

    
<!-- Header Area Neumorphic -->
    <div class="neu-flat p-6 rounded-b-[40px] mb-8 mt-2">
        <div class="flex justify-between items-center mb-6">
            <div>
                <!-- Mengambil nama panggilan langsung dari session -->
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Halo, <?= esc(session()->get('nama_panggilan') ?? 'Admin') ?>!</h1>
                <p class="text-sm md:text-base font-medium text-gray-500 mt-1">Pusat kendali sistem CyberGuard.</p>
            </div>
            
            <!-- Lingkaran Avatar Dinamis -->
            <a href="/profil" class="w-14 h-14 md:w-16 md:h-16 rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl md:text-3xl border-2 border-white overflow-hidden neu-pressed hover:scale-105 transition cursor-pointer">
                <?php if(session()->get('url_avatar')): ?>
                    <img src="/<?= esc(session()->get('url_avatar')) ?>" alt="Avatar Admin" class="w-full h-full object-cover">
                <?php else: ?>
                    <?= strtoupper(substr(session()->get('nama_panggilan') ?? 'A', 0, 1)) ?>
                <?php endif; ?>
            </a>
        </div>
<!-- Pustaka Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Area Grafik Dinamis -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
        
        <!-- Grafik Penyelesaian Modul -->
        <div class="neu-flat p-4 rounded-3xl">
            <h3 class="font-extrabold text-gray-800 text-xs mb-2">📈 Partisipasi per Modul</h3>
            <div class="relative h-40 w-full">
                <canvas id="modulChart"></canvas>
            </div>
        </div>

        <!-- Grafik Pengisian Kuesioner -->
        <div class="neu-flat p-4 rounded-3xl">
            <h3 class="font-extrabold text-gray-800 text-xs mb-2">📊 Responden Kuesioner</h3>
            <div class="relative h-40 w-full">
                <canvas id="kuesionerChart"></canvas>
            </div>
        </div>

    </div>
    </div>

    <!-- Script Render Grafik -->
    <script>
        // ==========================================
        // DATA DINAMIS DARI CONTROLLER (SIMULASI PHP)
        // Nantinya, cetak json_encode($data_dari_database) di sini
        // ==========================================
        
        // Contoh Data Modul (Otomatis menyesuaikan jumlah array)
        const labelModul = <?= json_encode($array_nama_modul) ?>;
        const dataModul = <?= json_encode($array_jumlah_siswa_selesai) ?>;

        // Contoh Data Kuesioner (Otomatis menyesuaikan jumlah array)
        const labelKuesioner = <?= json_encode($array_nama_kuesioner) ?>;
        const dataKuesioner = <?= json_encode($array_jumlah_responden) ?>;

        // Konfigurasi Standar Chart
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(163,177,198,0.3)' } },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        };

        // Render Grafik Modul (Warna Toska)
        new Chart(document.getElementById('modulChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelModul,
                datasets: [{
                    label: 'Siswa Selesai',
                    data: dataModul,
                    backgroundColor: 'rgba(20, 184, 166, 0.7)', // Teal-500
                    borderColor: 'rgba(20, 184, 166, 1)',
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });

        // Render Grafik Kuesioner (Warna Ungu)
        new Chart(document.getElementById('kuesionerChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelKuesioner,
                datasets: [{
                    label: 'Responden',
                    data: dataKuesioner,
                    backgroundColor: 'rgba(168, 85, 247, 0.7)', // Purple-500
                    borderColor: 'rgba(168, 85, 247, 1)',
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: chartOptions
        });
    </script>

    </div>
    
    <!-- Grid Statistik Cepat -->
    <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="neu-pressed p-6 rounded-3xl flex flex-col items-center justify-center text-center">
            <span class="text-[12px] font-bold text-gray-500 uppercase mt-1">Total Siswa</span>
            <span class="text-2xl font-extrabold text-blue-600"><?= $total_siswa ?></span>
        </div>
        <div class="neu-pressed p-6 rounded-3xl flex flex-col items-center justify-center text-center">
            <span class="text-[12px] font-bold text-gray-500 uppercase mt-1">Total Modul</span>
            <span class="text-2xl font-extrabold text-orange-500"><?= $total_modul ?></span>
        </div>
        <div class="neu-pressed p-6 rounded-3xl flex flex-col items-center justify-center text-center">
            <span class="text-[12px] font-bold text-gray-500 uppercase mt-1">Rata-rata Nilai</span>
            <span class="text-2xl font-extrabold text-green-600"><?= $rata_kuis ?>%</span>
        </div>
    </div>
    <!-- Progress/Statistik Agregat -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="neu-pressed p-4 rounded-2xl text-center">
                <span class="text-[12px] font-bold text-gray-500 uppercase">Total Modul Selesai</span>
                <span class="block text-2xl font-black text-teal-600"><?= $total_modul_selesai ?></span>
            </div>
            <div class="neu-pressed p-4 rounded-2xl text-center">
                <span class="text-[12px] font-bold text-gray-500 uppercase">Total Kuesioner Diisi</span>
                <span class="block text-2xl font-black text-purple-600"><?= $total_kuesioner_diisi ?></span>
            </div>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 flex-1">
        
        <!-- Tabel Aktivitas Kuis Terbaru -->
        <div class="neu-flat p-6 rounded-3xl flex flex-col">
            <h2 class="font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2 flex items-center">
                <span class="mr-2">📝</span> Progres Kuis Terbaru
            </h2>
            <div class="space-y-4 overflow-y-auto pr-2">
                <?php if(empty($progres_terbaru)): ?>
                    <p class="text-xs font-bold text-gray-400 text-center py-4">Belum ada data progres kuis.</p>
                <?php else: ?>
                    <?php foreach($progres_terbaru as $progres): ?>
                        <div class="neu-pressed p-4 rounded-2xl">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-bold text-sm text-blue-600"><?= esc($progres['nama_lengkap']) ?></h3>
                                <span class="text-xs font-bold <?= $progres['skor_kuis'] >= 70 ? 'text-green-500' : 'text-red-500' ?>"><?= $progres['skor_kuis'] ?> Poin</span>
                            </div>
                            <p class="text-xs font-bold text-gray-600 truncate"><?= esc($progres['judul_modul']) ?></p>
                            <p class="text-[10px] text-gray-400 mt-2 text-right"><?= date('d M Y, H:i', strtotime($progres['tanggal_selesai'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabel Aktivitas Simulasi CBT Terbaru -->
        <div class="neu-flat p-6 rounded-3xl flex flex-col">
            <h2 class="font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2 flex items-center">
                <span class="mr-2">🎮</span> Riwayat Simulasi CBT Terakhir
            </h2>
            <div class="space-y-4 overflow-y-auto pr-2">
                <?php if(empty($simulasi_terbaru)): ?>
                    <p class="text-xs font-bold text-gray-400 text-center py-4">Belum ada siswa yang memainkan simulasi.</p>
                <?php else: ?>
                    <?php foreach($simulasi_terbaru as $simulasi): ?>
                        <div class="neu-pressed p-4 rounded-2xl">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="font-bold text-sm text-orange-500"><?= esc($simulasi['nama_lengkap']) ?></h3>
                                <span class="text-xs font-bold <?= $simulasi['skor_kontrol_diri'] > 0 ? 'text-green-500' : 'text-red-500' ?>">
                                    <?= $simulasi['skor_kontrol_diri'] > 0 ? '+' : '' ?><?= $simulasi['skor_kontrol_diri'] ?> CBT Skor
                                </span>
                            </div>
                            <p class="text-xs font-bold text-gray-600 truncate"><?= esc($simulasi['judul_simulasi']) ?></p>
                            <p class="text-[10px] text-gray-400 mt-2 text-right"><?= date('d M Y, H:i', strtotime($simulasi['tanggal_percobaan'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

</body>
</html>
