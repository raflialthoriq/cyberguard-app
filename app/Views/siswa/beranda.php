<?php
/**
 * @var string $nama_panggilan
 * @var int $modul_selesai
 * @var int $total_modul
 * @var int $persentase
 * @var string $tips_harian
 * @var bool $sudah_isi_mood
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Siswa - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat {
            background-color: #E0E5EC;
            box-shadow: 9px 9px 16px rgb(163,177,198,0.6), -9px -9px 16px rgba(255,255,255,0.5);
        }
        .neu-btn {
            background-color: #E0E5EC;
            box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.6);
            transition: all 0.2s ease-in-out;
        }
        .neu-btn:active {
            box-shadow: inset 5px 5px 10px rgba(163,177,198,0.7), inset -5px -5px 10px rgba(255,255,255,1);
        }
        .neu-pressed {
            background-color: #E0E5EC;
            box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1);
        }
    </style>
</head>
<!-- Perhatikan class body ini: max-w-md sudah dihapus, diganti agar layar penuh, dan pb-24 agar konten tidak tertutup navigasi bawah -->
<body class="pb-28 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl relative min-h-screen">
    
    <!-- Header Area Neumorphic -->
    <div class="neu-flat p-6 rounded-b-[40px] mb-8 mt-2">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800">Halo, <?= esc($nama_panggilan) ?>! 👋</h1>
                <p class="text-sm md:text-base font-medium text-gray-500 mt-1">Siap melatih kontrol dirimu?</p>
            </div>
            <div class="w-14 h-14 md:w-16 md:h-16 neu-flat rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl md:text-3xl border-2 border-white">
                <?= strtoupper(substr($nama_panggilan, 0, 1)) ?>
            </div>
        </div>

        <!-- Progress Bar Melesak ke Dalam (Sekarang Dinamis!) -->
        <div class="neu-pressed p-4 rounded-2xl">
            <div class="flex justify-between text-sm md:text-base mb-3 font-bold text-gray-600">
                <span>Progres Belajarmu</span>
                <span class="text-blue-600"><?= $modul_selesai ?>/<?= $total_modul ?> Modul</span>
            </div>
            <div class="w-full neu-pressed rounded-full h-3 md:h-4">
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-3 md:h-4 rounded-full shadow-inner" style="width: <?= $persentase ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Area Konten Utama -->
    <div class="space-y-6">
        <?php if(session()->getFlashdata('pesan')): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-xl text-sm md:text-base text-center font-bold neu-flat">
                ✅ <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif; ?>

        <!-- Grid 2 Kolom untuk Layar Lebar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Quick Mood Check -->
            <div class="neu-flat p-5 md:p-8 rounded-3xl text-center border-t-4 border-blue-400 flex flex-col justify-center">
                <?php if($sudah_isi_mood): ?>
                    <span class="text-5xl mb-3 block">💖</span>
                    <h3 class="font-extrabold text-gray-800 text-base md:text-lg">Terima kasih sudah berbagi hari ini!</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1 font-bold">Jurnalmu tersimpan aman.</p>
                <?php else: ?>
                    <h3 class="font-extrabold text-gray-800 text-base md:text-lg mb-6">Bagaimana perasaanmu siang ini?</h3>
                    <div class="flex justify-center gap-6">
                        <a href="/siswa/jurnal" class="text-4xl md:text-5xl neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-110 transition">😢</a>
                        <a href="/siswa/jurnal" class="text-4xl md:text-5xl neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-110 transition">😐</a>
                        <a href="/siswa/jurnal" class="text-4xl md:text-5xl neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-110 transition">😄</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tips Hari Ini -->
            <div class="neu-pressed p-5 md:p-8 rounded-3xl relative overflow-hidden border-l-4 border-orange-400 flex flex-col justify-center">
                <h3 class="text-sm md:text-base font-extrabold text-orange-500 mb-3 uppercase tracking-widest">💡 Tips Hari Ini</h3>
                <p class="text-base md:text-lg font-bold text-gray-600 italic leading-relaxed">
                    "<?= esc($tips_harian) ?>"
                </p>
            </div>

        </div>
    </div>

   <!-- ============================================================== -->
    <!-- BOTTOM NAVIGATION BAR (Sesuai Dokumen Arsitektur)              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <!-- Menu 1: Beranda (Home) -->
            <a href="/siswa/beranda" class="flex flex-col items-center w-1/6 text-blue-600 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 drop-shadow-md">🏠</span>
                <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span>
            </a>
            
            <!-- Menu 2: Belajar (Learn) -->
            <a href="/siswa/modul" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span>
            </a>
            
            <!-- Menu 3: Latihan (Practice) -->
            <a href="/siswa/simulasi" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span>
            </a>
            
            <!-- Menu 4: Jurnal (Diary) -->
            <a href="/siswa/jurnal" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 relative grayscale hover:grayscale-0">
                    📔
                    <!-- Indikator merah (badge) jika belum isi mood -->
                    <?php if(!$sudah_isi_mood): ?>
                        <span class="absolute -top-1 -right-2 bg-red-500 w-3 h-3 rounded-full animate-pulse border-2 border-[#E0E5EC]"></span>
                    <?php endif; ?>
                </span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span>
            </a>
            
            <!-- Menu 5: Profil (Profile) -->
            <a href="/profil" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span>
            </a>

            <!-- Menu 6: Keluar (Logout) -->
            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

        </div>
    </nav>

</body>
</html>