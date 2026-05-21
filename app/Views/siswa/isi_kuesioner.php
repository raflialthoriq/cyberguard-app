<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($kuesioner['judul_kuesioner']) ?> - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        
        /* Gaya Radio Button Neumorphism */
        input[type="radio"]:checked + label {
            background-color: #a855f7; color: white;
            box-shadow: inset 3px 3px 6px rgba(0,0,0,0.3), inset -3px -3px 6px rgba(255,255,255,0.2);
            border-color: #a855f7;
        }
    </style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-3xl relative min-h-screen">
    
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-800"><?= esc($kuesioner['judul_kuesioner']) ?></h1>
        <p class="text-sm font-bold text-gray-500 mt-2"><?= esc($kuesioner['deskripsi']) ?></p>
    </div>

    <form action="/siswa/simpan_jawaban_kuesioner" method="POST" class="space-y-6">
        <input type="hidden" name="id_kuesioner" value="<?= $kuesioner['id_kuesioner'] ?>">

        <?php $no = 1; foreach($soal_kuesioner as $soal): ?>
            <div class="neu-flat p-6 md:p-8 rounded-3xl">
                <h3 class="font-extrabold text-gray-800 text-sm md:text-base mb-4">
                    <span class="text-purple-500 mr-1"><?= $no ?>.</span> <?= esc($soal['teks_soal']) ?>
                </h3>
                
                <div class="space-y-3">
                    <?php 
                    // Bongkar JSON opsi jawaban dari database
                    $opsi_array = json_decode($soal['opsi_jawaban'], true); 
                    foreach($opsi_array as $index => $opsi): 
                        $id_opsi = "soal_" . $soal['id_soal'] . "_opsi_" . $index;
                    ?>
                        <div class="relative">
                            <input type="radio" id="<?= $id_opsi ?>" name="jawaban[<?= $soal['id_soal'] ?>]" value="<?= esc($opsi) ?>" class="hidden" required>
                            <label for="<?= $id_opsi ?>" class="block w-full neu-pressed px-5 py-3 rounded-xl cursor-pointer text-xs md:text-sm font-bold text-gray-600 transition-all border-2 border-transparent hover:border-purple-300">
                                <?= esc($opsi) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php $no++; endforeach; ?>

        <button type="submit" class="w-full bg-purple-500 text-white font-extrabold py-4 rounded-xl shadow-lg hover:bg-purple-600 transition active:scale-95 text-sm md:text-base mt-4">
            Kirim Jawaban
        </button>
    </form>

    <!-- (Tempelkan Bottom Navigation Bar Siswa di sini seperti biasa) -->
    
</body>
</html>