<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Panduan Guru - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-6xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div><h1 class="text-2xl font-extrabold text-gray-800">CMS Panduan Fasilitator 📚</h1></div>
        <a href="/admin/beranda" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Beranda</a>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-white border-l-4 border-purple-500 text-purple-700 p-4 rounded-xl mb-6 text-xs font-bold neu-flat text-center"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-bold text-gray-800 mb-4 border-b pb-1">Tambah Panduan Baru</h2>
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
                
                <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-xl font-bold text-sm shadow hover:bg-purple-700 transition">Terbitkan Panduan Interaktif</button>
            </form>
        </div>

        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-bold text-gray-800 mb-4 border-b pb-1">Panduan Aktif</h2>
            <div class="space-y-4">
                <?php foreach($daftar_panduan as $p): ?>
                    <div class="neu-pressed p-4 rounded-xl flex flex-col md:flex-row justify-between md:items-center gap-4">
                        <div>
                            <span class="text-xs font-black text-purple-600">[<?= esc($p['kode_panduan']) ?>]</span>
                            <span class="text-[10px] bg-purple-100 text-purple-600 px-2 py-0.5 rounded ml-2 uppercase font-bold"><?= $p['tipe_media'] ?></span>
                            <h4 class="font-bold text-sm text-gray-800 mt-1"><?= esc($p['judul_panduan']) ?></h4>
                        </div>
                        <div class="flex gap-2">
                            <a href="/admin/edit_panduan/<?= $p['id_panduan'] ?>" class="bg-indigo-500 text-white text-xs font-bold px-4 py-2 rounded-lg shadow hover:bg-indigo-600 transition">✏️ Edit</a>
                            <a href="/admin/hapus_panduan/<?= $p['id_panduan'] ?>" onclick="return confirm('Yakin hapus panduan ini secara permanen?')" class="bg-red-100 text-red-600 font-bold px-3 py-2 rounded-lg text-xs hover:bg-red-200 transition">🗑️ Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if(empty($daftar_panduan)): ?>
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
            
            urlYoutube.classList.add('hidden'); fileMedia.classList.add('hidden');
            urlYoutube.required = false; fileMedia.required = false;

            if (tipe === 'youtube') {
                urlYoutube.classList.remove('hidden'); urlYoutube.required = true;
            } else if (['gambar', 'dokumen', 'audio'].includes(tipe)) {
                fileMedia.classList.remove('hidden'); fileMedia.required = true;
            }
        }
    </script>
</body>
</html>