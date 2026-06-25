<?php

/**
 * @var string $nama_panggilan
 * @var int $modul_selesai
 * @var int $total_modul
 * @var int $persentase
 * @var string $tips_harian
 * @var bool $sudah_isi_mood
 * @var int $streak_login
 * @var int $total_poin
 * @var string|null $url_avatar
 */
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Siswa - CyberGuard</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            background-color: #E0E5EC;
            box-shadow: 9px 9px 16px rgb(163, 177, 198, 0.6), -9px -9px 16px rgba(255, 255, 255, 0.5);
        }

        .neu-btn {
            background-color: #E0E5EC;
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.6);
            transition: all 0.2s ease-in-out;
        }

        .neu-btn:active {
            box-shadow: inset 5px 5px 10px rgba(163, 177, 198, 0.7), inset -5px -5px 10px rgba(255, 255, 255, 1);
        }

        .neu-pressed {
            background-color: #E0E5EC;
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 rgba(255, 255, 255, 1);
        }
    </style>
</head>

<body class="pb-28 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl relative min-h-screen">

    <div class="neu-flat p-6 rounded-b-[40px] mb-6 mt-2">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                    Halo, <?= esc($nama_panggilan) ?>! <i data-lucide="sparkles" class="w-6 h-6 text-yellow-500 fill-yellow-500"></i>
                </h1>
                <p class="text-sm md:text-base font-medium text-gray-500 mt-1">Siap melatih kontrol dirimu?</p>
            </div>

            <?php if (!empty($url_avatar)): ?>
                <img src="<?= base_url($url_avatar) ?>" alt="Avatar" class="w-14 h-14 md:w-16 md:h-16 rounded-full object-cover border-2 border-white shadow-md">
            <?php else: ?>
                <div class="w-14 h-14 md:w-16 md:h-16 neu-flat rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl md:text-3xl border-2 border-white shadow-md">
                    <?= strtoupper(substr($nama_panggilan, 0, 1)) ?>
                </div>
            <?php endif; ?>
        </div>

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

    <div class="space-y-6">
        <?php if (session()->getFlashdata('pesan')): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-xl text-sm md:text-base text-center font-bold neu-flat flex items-center justify-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i> <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif; ?>

        <div class="neu-flat p-5 md:p-6 rounded-[32px] flex items-center justify-around border-t-4 border-yellow-400">
            <div class="text-center w-1/2">
                <h3 class="text-[10px] md:text-xs font-extrabold text-gray-500 uppercase tracking-widest mb-2">Streak Login</h3>
                <div class="flex items-center justify-center gap-2">
                    <div class="w-10 h-10 neu-pressed rounded-full flex items-center justify-center text-orange-500">
                        <i data-lucide="flame" class="w-5 h-5 fill-orange-500"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-black text-gray-700"><?= esc($streak_login) ?> <span class="text-xs font-semibold text-gray-400">Hari</span></span>
                </div>
            </div>

            <div class="w-px h-12 bg-white/60 shadow-sm mx-2"></div>

            <div class="text-center w-1/2">
                <h3 class="text-[10px] md:text-xs font-extrabold text-gray-500 uppercase tracking-widest mb-2">Total XP / Poin</h3>
                <div class="flex items-center justify-center gap-2">
                    <div class="w-10 h-10 neu-pressed rounded-full flex items-center justify-center text-yellow-500">
                        <i data-lucide="star" class="w-5 h-5 fill-yellow-500"></i>
                    </div>
                    <span class="text-2xl md:text-3xl font-black text-gray-700"><?= esc($total_poin) ?> <span class="text-xs font-semibold text-gray-400">XP</span></span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="neu-flat p-5 md:p-8 rounded-3xl text-center border-t-4 border-blue-400 flex flex-col justify-center">

                <?php if ($baru_saja_isi_mood): ?>

                    <i data-lucide="heart-handshake" class="w-12 h-12 text-pink-500 mx-auto mb-3"></i>
                    <h3 class="font-extrabold text-gray-800 text-base md:text-lg">Terima kasih sudah berbagi hari ini!</h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1 font-bold">Jurnalmu tersimpan aman.</p>

                <?php else: ?>

                    <h3 class="font-extrabold text-gray-800 text-base md:text-lg mb-6">Bagaimana perasaanmu siang ini?</h3>
                    <div class="flex justify-center gap-6">
                        <a href="/siswa/jurnal" class="neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-105 transition text-red-500">
                            <i data-lucide="frown" class="w-10 h-10 md:w-12 md:h-12"></i>
                        </a>
                        <a href="/siswa/jurnal" class="neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-105 transition text-yellow-500">
                            <i data-lucide="meh" class="w-10 h-10 md:w-12 md:h-12"></i>
                        </a>
                        <a href="/siswa/jurnal" class="neu-btn w-20 h-20 md:w-24 md:h-24 flex items-center justify-center rounded-full hover:scale-105 transition text-green-500">
                            <i data-lucide="smile" class="w-10 h-10 md:w-12 md:h-12"></i>
                        </a>
                    </div>

                <?php endif; ?>
            </div>

            <?php
            $db = \Config\Database::connect();
            $undangan = $db->query("SELECT jk.*, p.nama_lengkap as nama_guru FROM jadwal_konseling jk JOIN pengguna p ON jk.id_guru = p.id_pengguna WHERE jk.id_siswa = ? AND jk.status = 'direncanakan' ORDER BY jk.tanggal_konseling ASC LIMIT 1", [session()->get('id_pengguna')])->getRowArray();
            if ($undangan):
            ?>
                <div class="neu-flat p-5 md:p-6 rounded-3xl border-l-4 border-orange-500 bg-orange-100/30">
                    <h4 class="text-xs font-black text-orange-700 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="bell-ring" class="w-4 h-4"></i> Panggilan Konseling
                    </h4>
                    <p class="text-sm font-bold text-gray-700 mt-2">Kamu dijadwalkan bertemu Guru BK: <span class="text-blue-600"><?= esc($undangan['nama_guru']) ?></span></p>
                    <p class="text-[11px] font-bold text-gray-500 mt-1 flex items-center gap-1">
                        <i data-lucide="clock" class="w-3 h-3"></i> <?= date('d M Y, H:i', strtotime($undangan['tanggal_konseling'])) ?> WIB
                    </p>
                    <p class="text-[11px] font-bold text-gray-500 flex items-center gap-1 mt-1">
                        <i data-lucide="map-pin" class="w-3 h-3"></i> <?= esc($undangan['catatan']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="neu-flat p-5 md:p-6 rounded-3xl mt-2 md:mt-0">
                <h3 class="font-black text-gray-800 mb-4 flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-blue-500"></i> Riwayat Konseling Saya
                </h3>
                <div class="max-h-32 overflow-y-auto pr-2 space-y-2">
                    <?php
                    $riwayat = $db->table('jadwal_konseling')->where('id_siswa', session()->get('id_pengguna'))->orderBy('tanggal_konseling', 'DESC')->get()->getResultArray();
                    if (empty($riwayat)): ?>
                        <p class="text-xs text-gray-400 italic">Belum ada riwayat konseling.</p>
                        <?php else:
                        foreach ($riwayat as $r): ?>
                            <div class="border-b border-gray-300/50 pb-2 text-xs font-bold flex justify-between items-center">
                                <span><?= date('d M Y', strtotime($r['tanggal_konseling'])) ?> - <?= esc($r['catatan']) ?></span>
                                <?php
                                $status_color = 'text-blue-500';
                                if ($r['status'] == 'selesai') $status_color = 'text-green-500';
                                if ($r['status'] == 'dibatalkan') $status_color = 'text-red-500';
                                ?>
                                <span class="<?= $status_color ?> capitalize">(<?= $r['status'] ?>)</span>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>

            <div class="neu-pressed p-5 md:p-8 rounded-3xl relative overflow-hidden border-l-4 border-orange-400 flex flex-col justify-center">
                <h3 class="text-sm md:text-base font-extrabold text-orange-500 mb-3 uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5"></i> Tips Hari Ini
                </h3>
                <p class="text-base md:text-lg font-bold text-gray-600 italic leading-relaxed">
                    "<?= esc($tips_harian) ?>"
                </p>
            </div>

        </div>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">

            <a href="/siswa/beranda" class="flex flex-col items-center w-1/6 text-blue-600 transition transform hover:-translate-y-1">
                <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1 drop-shadow-md"></i>
                <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span>
            </a>

            <a href="/siswa/modul" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1">
                <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span>
            </a>

            <a href="/siswa/simulasi" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1">
                <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span>
            </a>

            <a href="/siswa/jurnal" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 relative">
                <i data-lucide="notebook-pen" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <?php if (!$sudah_isi_mood): ?>
                    <span class="absolute top-0 right-3 md:right-5 bg-red-500 w-2.5 h-2.5 rounded-full animate-pulse border-2 border-[#E0E5EC]"></span>
                <?php endif; ?>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span>
            </a>

            <a href="/profil" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1">
                <i data-lucide="user-round" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span>
            </a>

            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>