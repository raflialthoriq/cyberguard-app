<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Panduan - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <style>
        body {
            background-color: #E0E5EC;
        }

        .neu-flat {
            box-shadow: 7px 7px 14px rgb(163, 177, 198, 0.6), -7px -7px 14px rgba(255, 255, 255, 0.7);
        }

        .neu-pressed {
            box-shadow: inset 6px 6px 10px 0 rgba(163, 177, 198, 0.7), inset -6px -6px 10px 0 #fff;
        }
    </style>
</head>

<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-4xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                <i data-lucide="square-pen" class="w-7 h-7 text-indigo-600"></i>
                Edit Panduan
            </h1>
        </div>
        <a href="/admin/kelola_panduan"
            class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500 flex items-center gap-2 hover:text-indigo-600 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali
        </a>
    </div>

    <div class="neu-flat p-6 md:p-8 rounded-3xl">
        <form action="/admin/update_panduan" method="POST" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="id_panduan" value="<?= $panduan['id_panduan'] ?>">
            <input type="hidden" name="file_lama" value="<?= $panduan['file_media'] ?>">

            <div class="flex gap-4">
                <div class="w-1/3">
                    <label class="block text-xs font-bold text-gray-500 mb-1">Kode</label>
                    <input type="text" name="kode_panduan" value="<?= esc($panduan['kode_panduan']) ?>" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none" required>
                </div>
                <div class="w-2/3">
                    <label class="block text-xs font-bold text-gray-500 mb-1">Judul Panduan</label>
                    <input type="text" name="judul_panduan" value="<?= esc($panduan['judul_panduan']) ?>" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none" required>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Tipe Media Tambahan</label>
                <select name="tipe_media" id="tipe_media_edit" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none" required onchange="toggleEditMedia()">
                    <option value="teks" <?= $panduan['tipe_media'] == 'teks' ? 'selected' : '' ?>>Hanya Teks Bacaan</option>
                    <option value="youtube" <?= $panduan['tipe_media'] == 'youtube' ? 'selected' : '' ?>>Video YouTube</option>
                    <option value="gambar" <?= $panduan['tipe_media'] == 'gambar' ? 'selected' : '' ?>>Gambar / Infografis</option>
                    <option value="dokumen" <?= $panduan['tipe_media'] == 'dokumen' ? 'selected' : '' ?>>Dokumen PDF</option>
                    <option value="audio" <?= $panduan['tipe_media'] == 'audio' ? 'selected' : '' ?>>Rekaman Audio (MP3)</option>
                </select>
            </div>

            <div id="wrapper_youtube" class="<?= $panduan['tipe_media'] == 'youtube' ? '' : 'hidden' ?>">
                <label class="block text-xs font-bold text-gray-500 mb-1">URL YouTube</label>
                <input type="url" name="url_youtube" id="url_youtube_edit" value="<?= esc($panduan['url_youtube'] ?? '') ?>" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none">
            </div>

            <div id="wrapper_file" class="<?= in_array($panduan['tipe_media'], ['gambar', 'dokumen', 'audio']) ? '' : 'hidden' ?>">
                <label class="block text-xs font-bold text-gray-500 mb-1">Unggah Media Baru (Abaikan jika tidak ingin mengganti file lama)</label>
                <input type="file" name="file_media" id="file_media_edit" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none">
                <?php if ($panduan['file_media']): ?>
                    <p class="text-[10px] text-blue-500 font-bold mt-2">File saat ini: <?= esc($panduan['file_media']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none" required><?= ($panduan['deskripsi']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">Teks Lengkap Panduan (Dapat Diformat)</label>
                <textarea name="konten_panduan" id="editor_edit" required><?= htmlspecialchars($panduan['konten_panduan']) ?></textarea>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white font-extrabold py-3.5 rounded-xl shadow-lg hover:bg-indigo-700 transition active:scale-95 text-sm mt-4 flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Perubahan Panduan
            </button>
        </form>
    </div>

    <!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">

            <a href="/admin/beranda" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1"> <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>

            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>

            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1"> <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1"> <i data-lucide="clipboard-list" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>

            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
                <i data-lucide="shield-check"
                    class="w-5 h-5 md:w-6 md:h-6 mb-1 text-indigo-600 group-hover:text-indigo-500 transition transform group-hover:-translate-y-0.5"></i>

                <!-- Teks "Akses" dengan Ikon Panah Ke Atas -->
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full text-indigo-600 group-hover:text-indigo-600 flex items-center justify-center gap-0.5 transition transform group-hover:-translate-y-0.5">
                    Akses
                    <svg class="w-2.5 h-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path>
                    </svg>
                </span>

                <!-- Popup Melayang -->
                <div id="menuAkses" class="hidden absolute bottom-full left-1/2 transform -translate-x-1/2 mb-3 bg-white rounded-2xl shadow-xl border border-gray-200 w-36 py-2 flex flex-col z-50 transition-all">
                    <!-- Segitiga penunjuk ke bawah -->
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-white rotate-45 border-b border-r border-gray-200"></div>

                    <a href="/admin/kelola_sekolah" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-green-600 hover:bg-green-50 transition border-b border-green-100">
                        <i data-lucide="school" class="w-4 h-4 mr-3"></i> Sekolah
                    </a>
                    <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <i data-lucide="users" class="w-4 h-4 mr-3"></i> Pengguna
                    </a>
                    <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <i data-lucide="lightbulb" class="w-4 h-4 mr-3"></i> Afirmasi
                    </a>
                    <a href="/admin/kelola_panduan" class="flex items-center px-4 py-3 text-xs font-bold text-blue-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-blue-100">
                        <i data-lucide="book" class="w-4 h-4 mr-3"></i> Panduan
                    </a>
                </div>
            </div>
            <!-- ========================================================= -->

            <a href="/admin/ekspor_riset" class="flex-1 flex flex-col items-center text-gray-400 hover:text-purple-600 transition transform hover:-translate-y-1"> <i data-lucide="download" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Ekspor</span> </a>

            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <i data-lucide="user" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>

            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <i data-lucide="log-out" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

    <script>
        // Inisialisasi Rich Text Editor
        CKEDITOR.replace('editor_edit', {
            height: 350,
            removePlugins: 'elementspath',
            resize_enabled: false
        });

        function toggleEditMedia() {
            const tipe = document.getElementById('tipe_media_edit').value;
            const wrapYoutube = document.getElementById('wrapper_youtube');
            const wrapFile = document.getElementById('wrapper_file');

            wrapYoutube.classList.add('hidden');
            wrapFile.classList.add('hidden');

            if (tipe === 'youtube') {
                wrapYoutube.classList.remove('hidden');
            } else if (['gambar', 'dokumen', 'audio'].includes(tipe)) {
                wrapFile.classList.remove('hidden');
            }
        }
    </script>

    <script>
        document.addEventListener('click', function() {
            const menu = document.getElementById('menuAkses');
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>