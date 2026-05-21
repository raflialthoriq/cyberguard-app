<?php
/**
 * @var array $skenario
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        
        /* Chat Bubble Style */
        .chat-bubble {
            background: #FFFFFF;
            border-radius: 20px 20px 20px 0px;
            box-shadow: 4px 4px 10px rgba(163,177,198,0.3);
        }
        
        /* Opsi Button */
        .opsi-btn { transition: all 0.2s ease; }
        .opsi-btn:hover { transform: scale(1.02); color: #3B82F6; }
        .opsi-btn:active { box-shadow: inset 4px 4px 8px rgba(163,177,198,0.7), inset -4px -4px 8px rgba(255,255,255,1); }
    </style>
</head>
<body class="flex flex-col h-screen font-sans text-gray-700">

    <!-- Header App Bar -->
    <div class="bg-[#128C7E] text-white p-4 flex items-center shadow-md z-10">
        <a href="/siswa/simulasi" class="mr-4 font-bold text-xl">←</a>
        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-xl mr-3">📱</div>
        <div>
            <h1 class="font-bold leading-tight"><?= esc($skenario['judul_simulasi']) ?></h1>
            <p class="text-xs text-green-200">Simulasi Interaktif</p>
        </div>
    </div>

    <!-- Area Skenario (Chat Area) -->
    <div class="flex-1 overflow-y-auto p-6 flex flex-col space-y-6" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
        
        <!-- Pesan Masuk (Narasi Kasus) -->
        <div class="flex items-end pr-10">
            <div class="chat-bubble p-4 text-sm text-gray-800 leading-relaxed">
                <span class="font-bold text-blue-500 text-xs mb-1 block">Situasi:</span>
                <?= esc($skenario['deskripsi_kasus']) ?>
            </div>
        </div>

    </div>

    <!-- Area Pilihan Respons (Bottom Sheet Neumorphic) -->
    <div class="neu-flat p-6 rounded-t-[40px] mt-auto">
        <p class="text-center text-xs font-bold text-gray-400 mb-4 uppercase tracking-wider">Apa yang akan kamu lakukan?</p>
        
        <form action="/siswa/simulasi/proses/<?= $skenario['id_skenario'] ?>" method="POST" class="space-y-4">
            
            <?php foreach($daftar_opsi as $opsi): ?>
                <button type="submit" name="pilihan_opsi" value="<?= $opsi['id_opsi'] ?>" class="opsi-btn neu-flat w-full text-left p-4 rounded-2xl text-sm font-bold text-gray-600 block leading-relaxed">
                    💬 <?= esc($opsi['teks_opsi']) ?>
                </button>
            <?php endforeach; ?>

        </form>
    </div>

</body>
</html>