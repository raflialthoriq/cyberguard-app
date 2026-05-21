<?php 
/** @var array $modul */ 
/** @var array $daftar_soal */ 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kuis - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-green { background-color: #10B981; box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4), -4px -4px 8px rgba(255,255,255,1); }
    </style>
</head>

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-blue-600 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
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

<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-28">

    <div class="p-6 flex items-center mb-2">
        <a href="/admin/kelola_modul" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4">←</a>
        <div>
            <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Kelola Kuis</h1>
            <p class="text-xs text-gray-500 font-bold">Modul: <?= esc($modul['judul_modul']) ?></p>
        </div>
    </div>

    <div class="px-6 space-y-8">
        
        <?php if(session()->getFlashdata('pesan')): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-xl text-sm text-center font-bold neu-flat">
                <?= session()->getFlashdata('pesan') ?>
            </div>
        <?php endif; ?>

        <!-- Form Tambah Soal Baru -->
        <div class="neu-flat p-6 rounded-3xl">
            <h2 class="font-bold text-blue-600 mb-4 border-b pb-2">Buat Soal Baru</h2>
            <form action="/admin/simpan_kuis/<?= $modul['id_modul'] ?>" method="POST" class="space-y-4">
                
                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 ml-2">Pertanyaan</label>
                    <textarea name="pertanyaan" class="neu-pressed w-full p-4 rounded-2xl focus:outline-none text-gray-700 resize-none h-20" placeholder="Ketik pertanyaan kuis..." required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-2">Pilihan A</label>
                        <input type="text" name="opsi_a" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-2">Pilihan B</label>
                        <input type="text" name="opsi_b" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1 ml-2">Pilihan C</label>
                        <input type="text" name="opsi_c" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-1 ml-2">Kunci Jawaban Benar</label>
                    <select name="jawaban_benar" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none font-bold text-blue-600 appearance-none text-center">
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                    </select>
                </div>

                <button type="submit" class="neu-btn-green w-full text-white font-bold py-3 rounded-xl mt-4">Simpan Soal ke Modul</button>
            </form>
        </div>

        <!-- Daftar Soal yang Sudah Ada -->
        <div class="space-y-4">
            <h2 class="font-bold text-gray-600 mb-2">Daftar Soal Tersimpan (<?= count($daftar_soal) ?>)</h2>
            <?php if(empty($daftar_soal)): ?>
                <div class="neu-pressed p-6 rounded-3xl text-center text-gray-400 font-bold text-sm">
                    Belum ada soal kuis untuk modul ini.
                </div>
            <?php else: ?>
                <?php foreach($daftar_soal as $index => $soal): ?>
                    <div class="neu-flat p-5 rounded-2xl relative">
                        <a href="/admin/hapus_kuis/<?= $soal['id_soal'] ?>" onclick="return confirm('Hapus soal ini?')" class="absolute top-4 right-4 w-8 h-8 neu-flat rounded-full flex items-center justify-center text-red-500 text-xs font-bold active:neu-pressed">X</a>
                        
                        <p class="text-sm font-bold text-gray-700 pr-8 mb-3"><?= $index + 1 ?>. <?= esc($soal['pertanyaan']) ?></p>
                        <ul class="text-xs text-gray-500 space-y-1">
                            <li class="<?= $soal['jawaban_benar'] == 'a' ? 'font-bold text-green-500' : '' ?>">A. <?= esc($soal['opsi_a']) ?></li>
                            <li class="<?= $soal['jawaban_benar'] == 'b' ? 'font-bold text-green-500' : '' ?>">B. <?= esc($soal['opsi_b']) ?></li>
                            <li class="<?= $soal['jawaban_benar'] == 'c' ? 'font-bold text-green-500' : '' ?>">C. <?= esc($soal['opsi_c']) ?></li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>