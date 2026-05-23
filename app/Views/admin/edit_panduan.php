<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Panduan - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-4xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div><h1 class="text-2xl font-extrabold text-gray-800">Edit Panduan ✏️</h1></div>
        <a href="/admin/kelola_panduan" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Kembali</a>
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

            <div id="wrapper_file" class="<?= in_array($panduan['tipe_media'], ['gambar','dokumen','audio']) ? '' : 'hidden' ?>">
                <label class="block text-xs font-bold text-gray-500 mb-1">Unggah Media Baru (Abaikan jika tidak ingin mengganti file lama)</label>
                <input type="file" name="file_media" id="file_media_edit" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none">
                <?php if($panduan['file_media']): ?>
                    <p class="text-[10px] text-blue-500 font-bold mt-2">File saat ini: <?= esc($panduan['file_media']) ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="w-full neu-pressed px-4 py-3 rounded-xl text-sm font-bold focus:outline-none" required><?= esc($panduan['deskripsi']) ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">Teks Lengkap Panduan (Dapat Diformat)</label>
                <textarea name="konten_panduan" id="editor_edit" required><?= htmlspecialchars($panduan['konten_panduan']) ?></textarea>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-extrabold py-3.5 rounded-xl shadow-lg hover:bg-indigo-700 transition active:scale-95 text-sm mt-4">
                💾 Simpan Perubahan Panduan
            </button>
        </form>
    </div>

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
</body>
</html>