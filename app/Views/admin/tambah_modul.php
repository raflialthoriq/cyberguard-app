<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Modul - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="icon" type="image/png" href="/public/logo.png">
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-green { background-color: #10B981; box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-green:active { box-shadow: inset 4px 4px 8px rgba(4, 120, 87, 0.6), inset -4px -4px 8px rgba(52, 211, 153, 0.5); }
    </style>
    
</head>
<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-28">

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <i data-lucide="house" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-teal-600"> <i data-lucide="book-open" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <i data-lucide="gamepad-2" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-green-600 transition transform hover:-translate-y-1"> <i data-lucide="clipboard-list" class="w-5 h-5 md:w-6 md:h-6 mb-1"></i> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
               <i data-lucide="shield-check"
   class="w-5 h-5 md:w-6 md:h-6 mb-1 text-gray-400 group-hover:text-indigo-500"></i>
                
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
                        <i data-lucide="school" class="w-4 h-4 mr-3"></i> Sekolah
                    </a>
                    <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <i data-lucide="users" class="w-4 h-4 mr-3"></i> Pengguna
                    </a>
                    <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <i data-lucide="lightbulb" class="w-4 h-4 mr-3"></i> Afirmasi
                    </a>
                    <a href="/admin/kelola_panduan" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
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

<!-- Script agar menu dropup tertutup otomatis jika area lain di layar diklik -->
<script>
    document.addEventListener('click', function(event) {
        const menuAkses = document.getElementById('menuAkses');
        if (menuAkses && !menuAkses.classList.contains('hidden')) {
            menuAkses.classList.add('hidden');
        }
    });
</script>

    <div class="p-6 flex items-center mb-2">
        <a href="/admin/kelola_modul" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4">←</a>
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Buat Modul Baru</h1>
    </div>

    <div class="flex-1 px-6">
        <!-- Tambahkan enctype agar bisa upload file -->
        <form action="/admin/simpan_modul" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-6">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Judul Modul</label>
                    <input type="text" name="judul_modul" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Urutan (Angka)</label>
                    <input type="number" name="urutan_modul" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold" required>
                </div>
            </div>

            <!-- Pilihan Tipe Media Utama -->
            <div>
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Jenis Media Tambahan</label>
                <select name="tipe_media" id="tipe_media" onchange="ubahTipeMedia()" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-gray-700 font-bold appearance-none">
                    <option value="teks">Hanya Teks Materi</option>
                    <option value="youtube">Video YouTube</option>
                    <option value="gambar">Gambar / Ilustrasi (JPG/PNG)</option>
                    <option value="audio">Audio / Podcast (MP3)</option>
                    <option value="dokumen">Dokumen Tambahan (PDF)</option>
                </select>
            </div>

            <!-- Input URL YouTube (Hidden by default) -->
            <div id="form_youtube" class="hidden">
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Link YouTube</label>
                <input type="url" name="url_youtube" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-blue-500 font-bold">
            </div>

            <!-- Input File (Hidden by default) -->
            <div id="form_file" class="hidden">
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Unggah File</label>
                <input type="file" name="file_media" class="neu-pressed w-full p-4 rounded-2xl focus:outline-none text-gray-700">
            </div>

            <div class="flex-1 flex flex-col">
                <label class="block text-sm font-bold mb-2 ml-2 text-gray-600">Konten Materi Utama (Teks)</label>
                <!-- Pustaka Quill.js (Gratis & Mobile Friendly) -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <div class="mb-5">
        <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-500 mb-2">Konten Materi Utama (Teks)</label>
        
        <!-- Editor Quill Container -->
        <div class="bg-[#E0E5EC] rounded-xl overflow-hidden border-2 border-white shadow-inner">
            <!-- Tempat Editor Muncul -->
            <div id="editor-container" style="min-height: 300px; max-height: 600px; overflow-y: auto;" class="bg-white/50 font-sans text-gray-700"></div>
        </div>

        <!-- Input Tersembunyi untuk dikirim ke Controller CodeIgniter -->
        <input type="hidden" name="konten_materi" id="hidden_konten_materi" required>
    </div>

    <!-- Script Inisialisasi Quill -->
    <script>
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Ketik materi Anda di sini',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],        // Ketebalan font
                    [{ 'align': [] }],                                // Rata Kiri/Tengah/Kanan
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],     // Numbering & Bullet
                    [{ 'color': [] }, { 'background': [] }],          // Warna teks
                    ['clean']                                         // Hapus format
                ]
            }
        });

        // Trik Penting: Pindahkan isi Quill ke Input Tersembunyi saat tombol Simpan ditekan
        document.querySelector('form').addEventListener('submit', function() {
            var htmlKonten = quill.root.innerHTML;
            document.querySelector('#hidden_konten_materi').value = htmlKonten;
        });
    </script>
            </div>

            <button type="submit" class="neu-btn-green w-full text-white font-bold py-4 rounded-2xl transition duration-300 mt-4">
                Simpan & Publikasikan Modul
            </button>
        </form>
    </div>

    <!-- Script untuk dinamis menyembunyikan/menampilkan kolom -->
    <script>
        function ubahTipeMedia() {
            const tipe = document.getElementById('tipe_media').value;
            const formYoutube = document.getElementById('form_youtube');
            const formFile = document.getElementById('form_file');

            // Reset tampilan
            formYoutube.classList.add('hidden');
            formFile.classList.add('hidden');

            if (tipe === 'youtube') {
                formYoutube.classList.remove('hidden');
            } else if (tipe === 'gambar' || tipe === 'dokumen' || tipe === 'audio') {
                formFile.classList.remove('hidden');
            }
        }
    </script>

    <script>
        lucide.createIcons();
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</body>
</html>