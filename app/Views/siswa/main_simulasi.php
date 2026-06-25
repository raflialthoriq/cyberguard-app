<?php
/**
 * @var array $skenario
 * @var bool $is_review
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi CBT - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #efeae2; }
        
        .chat-bubble {
            background: #FFFFFF;
            border-radius: 0px 8px 8px 8px; 
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
            position: relative;
        }
        .chat-bubble::before {
            content: ""; position: absolute; top: 0; left: -8px; width: 0; height: 0;
            border-top: 0px solid transparent; border-right: 8px solid #FFFFFF; border-bottom: 10px solid transparent;
        }

        /* Tambahan: Gelembung Pesan User (Hijau WA) */
        .chat-bubble-user {
            background: #d9fdd3;
            border-radius: 8px 0px 8px 8px; 
            box-shadow: 0 1px 0.5px rgba(0,0,0,0.13);
            position: relative;
        }
        .chat-bubble-user::before {
            content: ""; position: absolute; top: 0; right: -8px; width: 0; height: 0;
            border-top: 0px solid transparent; border-left: 8px solid #d9fdd3; border-bottom: 10px solid transparent;
        }

        .opsi-btn { background-color: #ffffff; border: 1px solid #e5e7eb; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .opsi-btn:hover { transform: scale(1.01); border-color: #128C7E; color: #128C7E; }
        .opsi-btn:active { background-color: #f3f4f6; }
    </style>
</head>

<body class="flex flex-col h-screen font-sans text-gray-700 relative">

    <div class="bg-[#128C7E] text-white p-3 flex items-center shadow-md z-20 shrink-0">
        <a href="/siswa/simulasi" class="mr-2 hover:bg-white/20 p-2 rounded-full transition">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3 shrink-0 overflow-hidden">
            <i data-lucide="user" class="w-6 h-6 text-gray-400 mt-1"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="font-bold leading-tight truncate text-base"><?= esc($skenario['judul_simulasi']) ?></h1>
            <p class="text-[11px] text-green-100 font-medium">Skenario Simulasi</p>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto p-4 flex flex-col space-y-4 bg-[#efeae2] pb-6 relative z-0" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.95;">
        
        <div class="flex justify-center mt-2 mb-1">
            <span class="bg-[#d9fdd3] text-gray-600 text-[10px] font-bold px-3 py-1 rounded-lg shadow-sm uppercase">Pusat Latihan CBT</span>
        </div>

        <div class="flex items-start pr-12">
            <div class="chat-bubble p-3 text-sm text-gray-800 leading-relaxed ml-2 mt-2">
                <span class="font-extrabold text-[#128C7E] text-[11px] mb-1 block">Kasus/Situasi:</span>
                <?= esc($skenario['deskripsi_kasus']) ?>
                <span class="text-[9px] text-gray-400 block text-right mt-1.5"><?= date('H:i') ?></span>
            </div>
        </div>

        <?php if($is_review && isset($opsi_terpilih)): ?>
            
            <div class="flex items-start justify-end pl-12 mt-4 animate-fade-in">
                <div class="chat-bubble-user p-3 text-sm text-gray-800 leading-relaxed mr-2">
                    <?= esc($opsi_terpilih['teks_opsi']) ?>
                    <span class="text-[9px] text-gray-500 block text-right mt-1.5 flex justify-end items-center gap-1">
                        <?= date('H:i', strtotime($riwayat['tanggal_percobaan'])) ?> 
                        <i data-lucide="check-check" class="w-3 h-3 text-blue-500"></i>
                    </span>
                </div>
            </div>

            <div class="flex items-start pr-12 mt-4 animate-fade-in delay-100">
                <div class="chat-bubble p-3 text-sm text-gray-800 leading-relaxed ml-2 border-l-4 <?= $opsi_terpilih['id_opsi'] == $opsi_terbaik['id_opsi'] ? 'border-green-500' : 'border-yellow-500' ?>">
                    <span class="font-extrabold text-[#128C7E] text-[11px] mb-1 block">Ulasan Ahli:</span>
                    <p class="mb-2"><?= esc($opsi_terpilih['feedback_opsi']) ?></p>
                    
                    <?php if(isset($opsi_terbaik) && $opsi_terpilih['id_opsi'] != $opsi_terbaik['id_opsi']): ?>
                        <div class="bg-blue-50 p-2.5 rounded-lg border border-blue-100 mt-3">
                            <span class="font-extrabold text-[10px] text-blue-600 block flex items-center gap-1 mb-1">
                                <i data-lucide="lightbulb" class="w-3 h-3"></i> Respons Paling Ideal:
                            </span>
                            <span class="italic text-gray-700 text-xs">"<?= esc($opsi_terbaik['teks_opsi']) ?>"</span>
                        </div>
                    <?php endif; ?>

                    <span class="text-[9px] text-gray-400 block text-right mt-1.5"><?= date('H:i') ?></span>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <div class="bg-gray-50 p-5 rounded-t-3xl shadow-[0_-4px_15px_rgba(0,0,0,0.05)] z-10 shrink-0 pb-28 border-t border-gray-200">
        
        <?php if($is_review): ?>
            <p class="text-center text-[11px] font-bold text-green-600 mb-3 uppercase tracking-wider flex items-center justify-center gap-1">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i> Simulasi Selesai Dievaluasi
            </p>
            <a href="/siswa/simulasi" class="block w-full text-center bg-gray-200 text-gray-700 px-4 py-3.5 rounded-xl text-sm font-bold hover:bg-gray-300 transition active:scale-95">
                Kembali ke Daftar Latihan
            </a>
        <?php else: ?>
            <p class="text-center text-[11px] font-bold text-gray-400 mb-4 uppercase tracking-wider flex items-center justify-center gap-1">
                <i data-lucide="help-circle" class="w-4 h-4"></i> Pilih Responsmu
            </p>
            <form action="/siswa/simulasi/proses/<?= $skenario['id_skenario'] ?>" method="POST" class="space-y-3">
                <?php foreach ($daftar_opsi as $opsi): ?>
                    <button type="submit" name="pilihan_opsi" value="<?= $opsi['id_opsi'] ?>" class="opsi-btn w-full text-left px-4 py-3.5 rounded-xl text-sm font-bold text-gray-700 flex items-center gap-3">
                        <i data-lucide="message-square-reply" class="w-5 h-5 text-gray-400 shrink-0"></i>
                        <span><?= esc($opsi['teks_opsi']) ?></span>
                    </button>
                <?php endforeach; ?>
            </form>
        <?php endif; ?>

    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition w-1/6">
                <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold">Beranda</span>
            </a>
            <a href="/siswa/modul" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition w-1/6">
                <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold">Belajar</span>
            </a>
            <a href="/siswa/simulasi" class="flex flex-col items-center text-orange-600 hover:text-orange-500 transition w-1/6">
                <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1 drop-shadow-md"></i> <span class="text-[9px] md:text-[10px] font-extrabold">Latihan</span>
            </a>
            <a href="/siswa/jurnal" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition w-1/6">
                <i data-lucide="notebook-pen" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold">Jurnal</span>
            </a>
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-400 transition w-1/6">
                <i data-lucide="user-round" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold">Profil</span>
            </a>
            <a href="/auth/logout" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition w-1/6">
                <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold">Keluar</span>
            </a>
        </div>
    </nav>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script> lucide.createIcons(); </script>
</body>
</html>