<?php
/**
 * @var array $modul
 * @var array $daftar_soal
 * @var array $progres
 * @var array $jawaban_tersimpan
 * @var bool  $is_remedial
 */
// Kuis terkunci secara visual (Read-Only) HANYA JIKA status selesai dan TIDAK sedang klik Remedial
$is_selesai = (isset($progres) && $progres['status_modul'] == 'selesai' && !$is_remedial);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis: <?= esc($modul['judul_modul']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-orange { background-color: #F97316; box-shadow: 4px 4px 8px rgba(249, 115, 22, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-green { background-color: #10B981; box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-blue { background-color: #3B82F6; box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        
        input[type="radio"] { display: none; }
        .opsi-label { transition: all 0.2s ease; border: 2px solid transparent; }
        
        /* Jika diklik, Override (timpa) warna merah/hijau dari history menjadi biru (tanda sedang dipilih ulang) */
        form:not(.mode-selesai) input[type="radio"]:checked + .opsi-label {
            box-shadow: inset 4px 4px 8px rgba(163,177,198,0.7), inset -4px -4px 8px rgba(255,255,255,1);
            border-color: #3B82F6 !important; 
            background-color: #EFF6FF !important; 
            color: #1D4ED8 !important; 
            font-weight: bold;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-10">

    <div class="p-6 flex items-center mb-4">
        <a href="/siswa/modul" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4">←</a>
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Lembar Kuis</h1>
    </div>

    <div class="px-6 flex-1">
        
        <!-- Notifikasi dari Controller -->
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 text-sm text-center font-bold neu-flat border-l-4 border-green-500">
                <?= session()->getFlashdata('pesan_sukses') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 text-sm text-center font-bold neu-flat border-l-4 border-red-500">
                <?= session()->getFlashdata('pesan_gagal') ?>
            </div>
        <?php endif; ?>

        <?php if(empty($daftar_soal)): ?>
            <div class="neu-pressed p-8 rounded-3xl text-center text-gray-500 font-bold">Kuis belum tersedia!</div>
        <?php else: ?>
            <form action="/siswa/modul/proses_kuis/<?= $modul['id_modul'] ?>" method="POST" class="space-y-8 <?= $is_selesai ? 'mode-selesai' : '' ?>">
                
                <?php foreach($daftar_soal as $index => $soal): 
                    $id_s = $soal['id_soal'];
                    $jawaban_user = isset($jawaban_tersimpan[$id_s]) ? $jawaban_tersimpan[$id_s] : null;
                    $kunci = $soal['jawaban_benar'];
                ?>
                    <div class="neu-flat p-6 rounded-3xl">
                        <p class="text-sm font-bold text-gray-800 mb-6 leading-relaxed">
                            <span class="text-blue-500 mr-1"><?= $index + 1 ?>.</span> <?= esc($soal['pertanyaan']) ?>
                        </p>
                        
                        <div class="space-y-4">
                            <?php foreach(['a', 'b', 'c'] as $opsi_val): 
                                $teks_opsi = $soal['opsi_' . $opsi_val];
                                $is_chosen_previously = ($jawaban_user === $opsi_val);
                                $is_correct = ($kunci === $opsi_val);
                                
                                $label_class = "opsi-label neu-flat block w-full p-4 rounded-2xl cursor-pointer text-sm text-gray-600 relative";
                                $ikon_status = "";

                                // Visualisasi Jawaban (Pewarnaan Merah/Hijau HANYA pada jawaban yang dipilih user)
                                if ($jawaban_user && $is_chosen_previously) {
                                    if ($is_correct) {
                                        $label_class .= " bg-green-50 border-2 border-green-500 font-bold text-green-700 shadow-inner";
                                        $ikon_status = "✅";
                                    } else {
                                        $label_class .= " bg-red-50 border-2 border-red-500 font-bold text-red-700 shadow-inner";
                                        $ikon_status = "❌";
                                    }
                                } elseif ($is_selesai) {
                                    $label_class .= " opacity-50 cursor-not-allowed"; // Redupkan yang tidak dipilih jika sudah tuntas
                                }
                            ?>
                                <div>
                                    <input type="radio" id="soal_<?= $id_s ?>_<?= $opsi_val ?>" name="soal_<?= $id_s ?>" value="<?= $opsi_val ?>" <?= $is_selesai ? 'disabled' : '' ?> <?= $is_chosen_previously ? 'checked' : '' ?> required>
                                    <label for="soal_<?= $id_s ?>_<?= $opsi_val ?>" class="<?= $label_class ?>">
                                        <?= strtoupper($opsi_val) ?>. <?= esc($teks_opsi) ?>
                                        <?php if($ikon_status): ?>
                                            <span class="absolute right-4 top-4 text-lg"><?= $ikon_status ?></span>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="pt-6">
                    <?php if($is_selesai): ?>
                        <div class="flex space-x-4">
                            <a href="/siswa/modul" class="neu-btn-green flex-1 flex items-center justify-center text-white font-bold py-4 rounded-2xl transition duration-300">
                                Modul Berikutnya ➔
                            </a>
                            <a href="?remedial=1" class="neu-btn-blue flex items-center justify-center text-white font-bold py-4 px-6 rounded-2xl transition duration-300" title="Tingkatkan Nilai">
                                🔄 Remedial
                            </a>
                        </div>
                    <?php else: ?>
                        <button type="submit" class="neu-btn-orange w-full text-white font-bold py-4 rounded-2xl transition duration-300">
                            Kirim Jawaban
                        </button>
                    <?php endif; ?>
                </div>

            </form>
        <?php endif; ?>
    </div>

</body>
</html>