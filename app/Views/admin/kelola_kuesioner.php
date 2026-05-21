<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Kuesioner - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
    </style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl relative min-h-screen">
    
    <div class="mt-8 mb-6">
        <h1 class="text-2xl font-extrabold text-gray-800">CMS Kuesioner Dinamis 📝</h1>
        <p class="text-sm font-bold text-gray-500">Buat instrumen evaluasi dengan skala kustom (Muncul di Menu Modul Siswa).</p>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 text-sm font-bold text-center neu-flat">
            ✅ <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: Form Tambah Kuesioner Dinamis -->
        <div class="lg:col-span-2 neu-flat p-6 rounded-3xl">
            <h2 class="font-extrabold text-gray-800 mb-6 border-b-2 border-gray-300 pb-2">Buat Kuesioner Baru</h2>
            
            <form action="/admin/simpan_kuesioner" method="POST">
                <!-- Info Kuesioner -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-500 mb-2">Judul Kuesioner</label>
                        <input type="text" name="judul_kuesioner" placeholder="Contoh: Pre-Test" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700" required>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-500 mb-2">Urutan Tampil</label>
                        <input type="number" name="urutan_tampil" placeholder="Misal: 1 (Muncul pertama)" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700" required>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-500 mb-2">Deskripsi / Instruksi</label>
                    <textarea name="deskripsi" rows="2" placeholder="Jawablah pernyataan di bawah ini dengan sejujurnya..." class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700 resize-none"></textarea>
                </div>

                <!-- Wadah Dinamis untuk Soal-soal -->
                <div id="wadah-soal" class="space-y-4 mb-6">
                    <!-- Soal akan ditambahkan ke sini oleh JavaScript -->
                </div>

                <!-- Tombol Kendali -->
                <div class="flex gap-4">
                    <button type="button" onclick="tambahSoal()" class="w-1/2 neu-flat text-purple-600 font-extrabold py-3 rounded-xl hover:text-purple-800 transition active:scale-95 text-sm border-2 border-purple-200 border-dashed">
                        ➕ Tambah Soal
                    </button>
                    <button type="submit" class="w-1/2 bg-blue-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-blue-600 transition active:scale-95 text-sm">
                        💾 Simpan Kuesioner
                    </button>
                </div>
            </form>
        </div>

        <!-- KOLOM KANAN: Daftar Kuesioner -->
        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-extrabold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">Kuesioner Aktif</h2>
            <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                <?php foreach($daftar_kuesioner as $k): ?>
                    <div class="neu-pressed p-4 rounded-2xl">
                        <h3 class="font-bold text-sm text-gray-800"><?= esc($k['judul_kuesioner']) ?></h3>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-[10px] font-extrabold text-gray-500 bg-[#E0E5EC] px-2 py-1 rounded-md shadow-sm"><?= $k['jumlah_soal'] ?> Soal | Urutan: <?= $k['urutan_tampil'] ?></span>
                            <span class="text-[10px] font-bold <?= $k['status_aktif'] ? 'text-green-500' : 'text-red-500' ?>">
                                <?= $k['status_aktif'] ? '🟢 Aktif' : '🔴 Nonaktif' ?>
                            </span>
                        </div>
                        
                        <!-- TOMBOL AKSI BARU -->
                        <div class="mt-4 flex flex-wrap gap-2 border-t border-gray-300 pt-3">
                            <a href="/admin/laporan_kuesioner/<?= $k['id_kuesioner'] ?>" class="text-[10px] bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg font-bold hover:bg-blue-200 transition">📊 Laporan Siswa</a>
                            <a href="/admin/edit_kuesioner/<?= $k['id_kuesioner'] ?>" class="text-[10px] bg-orange-100 text-orange-600 px-3 py-1.5 rounded-lg font-bold hover:bg-orange-200 transition">✏️ Edit</a>
                            <a href="/admin/hapus_kuesioner/<?= $k['id_kuesioner'] ?>" onclick="return confirm('Yakin ingin menghapus? SEMUA jawaban siswa di kuesioner ini akan ikut terhapus permanen!')" class="text-[10px] bg-red-100 text-red-600 px-3 py-1.5 rounded-lg font-bold hover:bg-red-200 transition">🗑️ Hapus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if(empty($daftar_kuesioner)): ?>
                    <p class="text-xs font-bold text-gray-400 text-center py-4">Belum ada kuesioner.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- SCRIPT JAVASCRIPT UNTUK FORM DINAMIS -->
    <script>
        let hitungSoal = 0; // Index array soal

        function tambahSoal() {
            const wadah = document.getElementById('wadah-soal');
            const elemenSoal = document.createElement('div');
            elemenSoal.className = 'neu-pressed p-5 rounded-2xl border-l-4 border-purple-500 relative';
            elemenSoal.id = `soal-${hitungSoal}`;

            // Struktur HTML untuk 1 Soal
            elemenSoal.innerHTML = `
                <button type="button" onclick="hapusElemen('soal-${hitungSoal}')" class="absolute top-4 right-4 text-red-400 hover:text-red-600 font-bold text-xl">&times;</button>
                <label class="block text-xs font-extrabold text-gray-600 mb-2">Pertanyaan Soal #${hitungSoal + 1}</label>
                <input type="text" name="soal[${hitungSoal}][teks]" placeholder="Ketik pertanyaan / pernyataan di sini..." class="w-full bg-transparent border-b-2 border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 mb-4" required>
                
                <div class="pl-4 border-l-2 border-gray-300">
                    <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Opsi Skala Radiobox:</label>
                    <div id="wadah-opsi-${hitungSoal}" class="space-y-2 mb-3">
                        <!-- Input Opsi default (Minimal 2 opsi) -->
                        <div class="flex gap-2">
                            <input type="text" name="soal[${hitungSoal}][opsi][]" placeholder="Misal: Sangat Setuju" class="w-full text-xs font-bold bg-white px-3 py-2 rounded-lg border border-gray-200 focus:outline-none" required>
                        </div>
                        <div class="flex gap-2">
                            <input type="text" name="soal[${hitungSoal}][opsi][]" placeholder="Misal: Setuju" class="w-full text-xs font-bold bg-white px-3 py-2 rounded-lg border border-gray-200 focus:outline-none" required>
                        </div>
                    </div>
                    <button type="button" onclick="tambahOpsi(${hitungSoal})" class="text-[10px] bg-purple-100 text-purple-600 px-3 py-1 rounded-lg font-bold hover:bg-purple-200 transition">
                        + Tambah Opsi Pilihan
                    </button>
                </div>
            `;
            
            wadah.appendChild(elemenSoal);
            hitungSoal++;
        }

        function tambahOpsi(indexSoal) {
            const wadahOpsi = document.getElementById(`wadah-opsi-${indexSoal}`);
            const divOpsi = document.createElement('div');
            divOpsi.className = 'flex gap-2 relative';
            divOpsi.innerHTML = `
                <input type="text" name="soal[${indexSoal}][opsi][]" placeholder="Opsi baru..." class="w-full text-xs font-bold bg-white px-3 py-2 rounded-lg border border-gray-200 focus:outline-none" required>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 font-extrabold px-2">&times;</button>
            `;
            wadahOpsi.appendChild(divOpsi);
        }

        function hapusElemen(idElemen) {
            document.getElementById(idElemen).remove();
        }

        // Panggil 1x saat halaman dimuat agar langsung ada 1 form soal kosong
        window.onload = function() {
            tambahSoal();
        };
    </script>

    <!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-blue-600  hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
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
    
</body>
</html>