<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Modul - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-green { background-color: #10B981; box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-green:active { box-shadow: inset 4px 4px 8px rgba(4, 120, 87, 0.6), inset -4px -4px 8px rgba(52, 211, 153, 0.5); }
    </style>
    
</head>
<body class="flex flex-col min-h-screen font-sans text-gray-700 pb-10">

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
</body>
</html>