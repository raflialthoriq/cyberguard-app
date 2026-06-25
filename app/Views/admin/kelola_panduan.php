<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pengguna - CyberGuard</title>
    <link rel="icon" type="image/png" href="logo.png">
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

<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-6xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 neu-flat rounded-2xl flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6 text-purple-600"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-800">
                    CMS Panduan Fasilitator
                </h1>
                <p class="text-sm font-bold text-gray-500">
                    Kelola panduan interaktif untuk fasilitator dan guru.
                </p>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('pesan')): ?>
        <div class="bg-white border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 text-xs font-bold neu-flat">
            <div class="flex items-center gap-2">
                <i data-lucide="badge-check" class="w-5 h-5"></i>
                <?= session()->getFlashdata('pesan') ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5 text-purple-600"></i>
                Tambah Panduan Baru
            </h2>
            <form action="/admin/simpan_panduan" method="POST" enctype="multipart/form-data" class="space-y-4">

                <div class="flex gap-2">
                    <input type="text" name="kode_panduan" placeholder="Kode (Misal: G5)" class="w-1/3 neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none" required>
                    <input type="text" name="judul_panduan" placeholder="Judul Modul Panduan" class="w-2/3 neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none" required>
                </div>

                <select name="tipe_media" id="tipe_media" class="w-full neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none" required onchange="toggleMediaInput()">
                    <option value="teks">Hanya Teks Bacaan</option>
                    <option value="youtube">Video YouTube</option>
                    <option value="gambar">Gambar / Infografis</option>
                    <option value="dokumen">Dokumen PDF</option>
                    <option value="audio">Rekaman Audio (MP3)</option>
                </select>

                <input type="url" name="url_youtube" id="url_youtube" placeholder="Link YouTube (https://...)" class="w-full neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none hidden">
                <input type="file" name="file_media" id="file_media" class="w-full neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none hidden">

                <textarea name="deskripsi" placeholder="Deskripsi Singkat (Tampil di menu depan)" class="w-full neu-pressed px-3 py-2 rounded-xl text-sm font-bold focus:outline-none" required></textarea>

                <div>
                    <label class="block text-xs font-bold text-gray-500 mb-2">Teks Lengkap Panduan (Mendukung Format):</label>
                    <textarea name="konten_panduan" id="editor_tambah" required></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-purple-600 text-white py-3 rounded-xl font-bold text-sm shadow hover:bg-purple-700 transition flex items-center justify-center gap-2">

                    <i data-lucide="send" class="w-4 h-4"></i>
                    Terbitkan Panduan Interaktif
                </button>
            </form>
        </div>

        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                <i data-lucide="library" class="w-5 h-5 text-indigo-600"></i>
                Panduan Aktif
            </h2>
            <div class="space-y-4">
                <?php foreach ($daftar_panduan as $p): ?>
                    <div class="neu-pressed p-4 rounded-xl flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div>
                            <span class="text-xs font-black text-purple-600">[<?= esc($p['kode_panduan']) ?>]</span>
                            <span class="text-[10px] bg-purple-100 text-purple-600 px-2 py-0.5 rounded ml-2 uppercase font-bold"><?= $p['tipe_media'] ?></span>
                            <h4 class="font-bold text-sm text-gray-800 mt-1"><?= esc($p['judul_panduan']) ?></h4>
                        </div>
                        <div class="flex gap-2">
                            <a href="/admin/edit_panduan/<?= $p['id_panduan'] ?>"
                                class="bg-indigo-500 text-white text-xs font-bold px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition flex items-center gap-2">
                                <i data-lucide="square-pen" class="w-4 h-4"></i>
                                Edit
                            </a>
                            <a href="/admin/hapus_panduan/<?= $p['id_panduan'] ?>"
                                onclick="return confirm('Yakin hapus panduan ini secara permanen?')"
                                class="bg-red-100 text-red-600 font-bold px-3 py-2 rounded-lg text-xs hover:bg-red-200 transition flex items-center gap-2">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                Hapus
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($daftar_panduan)): ?>
                    <p class="text-center text-gray-400 font-bold text-sm py-4">Belum ada panduan yang diterbitkan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Aktivasi CKEditor
        CKEDITOR.replace('editor_tambah', {
            height: 250,
            removePlugins: 'elementspath',
            resize_enabled: false
        });

        // Logika Tampil Sembunyi Tipe Media
        function toggleMediaInput() {
            const tipe = document.getElementById('tipe_media').value;
            const urlYoutube = document.getElementById('url_youtube');
            const fileMedia = document.getElementById('file_media');

            urlYoutube.classList.add('hidden');
            fileMedia.classList.add('hidden');
            urlYoutube.required = false;
            fileMedia.required = false;

            if (tipe === 'youtube') {
                urlYoutube.classList.remove('hidden');
                urlYoutube.required = true;
            } else if (['gambar', 'dokumen', 'audio'].includes(tipe)) {
                fileMedia.classList.remove('hidden');
                fileMedia.required = true;
            }
        }
    </script>

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
        lucide.createIcons();

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

</body>

</html>