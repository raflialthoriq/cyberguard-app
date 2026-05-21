<?php /** @var array $modul */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Modul - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-blue { background-color: #3B82F6; box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4), -4px -4px 8px rgba(255,255,255,1); }
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
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Edit Modul</h1>
    </div>

    <div class="px-6">
        <!-- Tambahkan enctype agar form bisa mengubah file -->
        <form action="/admin/update_modul/<?= $modul['id_modul'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Judul Modul</label>
                    <input type="text" name="judul_modul" value="<?= esc($modul['judul_modul']) ?>" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Urutan (Angka)</label>
                    <input type="number" name="urutan_modul" value="<?= esc($modul['urutan_modul']) ?>" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold" required>
                </div>
            </div>

            <!-- Tipe Media -->
            <div>
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Jenis Media Tambahan</label>
                <select name="tipe_media" id="tipe_media" onchange="ubahTipeMedia()" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold">
                    <option value="teks" <?= $modul['tipe_media'] == 'teks' ? 'selected' : '' ?>>Hanya Teks Materi</option>
                    <option value="youtube" <?= $modul['tipe_media'] == 'youtube' ? 'selected' : '' ?>>Video YouTube</option>
                    <option value="gambar" <?= $modul['tipe_media'] == 'gambar' ? 'selected' : '' ?>>Gambar / Ilustrasi (JPG/PNG)</option>
                    <option value="audio" <?= $modul['tipe_media'] == 'audio' ? 'selected' : '' ?>>Audio / Podcast (MP3)</option>
                    <option value="dokumen" <?= $modul['tipe_media'] == 'dokumen' ? 'selected' : '' ?>>Dokumen Tambahan (PDF)</option>
                </select>
            </div>

            <!-- Input URL YouTube -->
            <div id="form_youtube" class="<?= $modul['tipe_media'] == 'youtube' ? '' : 'hidden' ?>">
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Link YouTube</label>
                <input type="url" name="url_youtube" value="<?= esc($modul['url_youtube']) ?>" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-blue-500 font-bold">
            </div>

            <!-- Input File -->
            <div id="form_file" class="<?= in_array($modul['tipe_media'], ['gambar', 'dokumen', 'audio']) ? '' : 'hidden' ?>">
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Ganti File (Opsional)</label>
                <input type="file" name="file_media" class="neu-pressed w-full p-4 rounded-2xl focus:outline-none text-gray-700">
                <?php if(!empty($modul['file_media'])): ?>
                    <p class="text-xs text-orange-500 font-bold mt-2 ml-2">File saat ini: <?= esc($modul['file_media']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Konten Materi Utama (Teks)</label>
                <textarea name="konten_materi" class="neu-pressed w-full p-5 rounded-3xl focus:outline-none text-gray-700 resize-none h-40" required><?= esc($modul['konten_materi']) ?></textarea>
            </div>

            <button type="submit" class="neu-btn-blue w-full text-white font-bold py-4 rounded-2xl transition duration-300 mt-4">
                Simpan Perubahan Modul
            </button>
        </form>
    </div>

    <script>
        function ubahTipeMedia() {
            const tipe = document.getElementById('tipe_media').value;
            const formYoutube = document.getElementById('form_youtube');
            const formFile = document.getElementById('form_file');

            formYoutube.classList.add('hidden');
            formFile.classList.add('hidden');

            if (tipe === 'youtube') {
                formYoutube.classList.remove('hidden');
            } else if (tipe === 'gambar' || tipe === 'dokumen' || tipe === 'audio') {
                formFile.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>