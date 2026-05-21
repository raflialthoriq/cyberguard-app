<?php 
/** @var array $skenario */ 
/** @var array $daftar_opsi */ 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Simulasi Dinamis - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-blue { background-color: #3B82F6; box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4), -4px -4px 8px rgba(255,255,255,1); }
        .neu-btn-orange { background-color: #F97316; box-shadow: 4px 4px 8px rgba(249, 115, 22, 0.4), -4px -4px 8px rgba(255,255,255,1); }
    </style>
</head>

<!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-blue-600 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

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
        <a href="/admin/kelola_simulasi" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed mr-4">←</a>
        <h1 class="text-xl font-extrabold text-gray-700 tracking-wide">Edit Skenario CBT</h1>
    </div>

    <div class="px-6">
        <form action="/admin/update_simulasi/<?= $skenario['id_skenario'] ?>" method="POST" class="space-y-6">

            <!-- Kasus Utama -->
            <div class="neu-flat p-6 rounded-3xl space-y-4 border-l-4 border-blue-500">
                <h2 class="font-bold text-blue-600">1. Kasus Utama</h2>
                <input type="text" name="judul_simulasi" value="<?= esc($skenario['judul_simulasi']) ?>" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none font-bold" required>
                <textarea name="deskripsi_kasus" class="neu-pressed w-full p-5 rounded-2xl focus:outline-none resize-none h-24" required><?= esc($skenario['deskripsi_kasus']) ?></textarea>
            </div>

            <!-- Area Looping Opsi Dinamis -->
            <div id="wadah-opsi" class="space-y-6">
                <?php if(empty($daftar_opsi)): ?>
                    <!-- Jika skenario lama belum punya opsi di tabel baru -->
                    <div class="opsi-item neu-flat p-6 rounded-3xl space-y-4">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="font-bold text-gray-600 label-opsi">Opsi Jawaban Baru</h2>
                            <button type="button" onclick="hapusOpsi(this)" class="text-red-500 font-bold text-xs bg-red-100 px-3 py-1 rounded-full">Hapus</button>
                        </div>
                        <input type="text" name="teks_opsi[]" placeholder="Teks Pilihan Respons" class="neu-pressed w-full px-5 py-3 rounded-xl focus:outline-none" required>
                        <textarea name="feedback_opsi[]" placeholder="Feedback CBT..." class="neu-pressed w-full p-3 rounded-xl focus:outline-none resize-none" required></textarea>
                        <div class="flex items-center">
                            <label class="text-sm font-bold mr-3 text-gray-500">Skor (Positif/Negatif):</label>
                            <input type="number" name="skor_opsi[]" placeholder="Misal: -5, 0, atau 10" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none font-bold" required>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Menampilkan semua opsi yang sudah ada di database -->
                    <?php foreach($daftar_opsi as $index => $opsi): ?>
                        <div class="opsi-item neu-flat p-6 rounded-3xl space-y-4">
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="font-bold text-gray-600 label-opsi">Opsi Jawaban <?= $index + 1 ?></h2>
                                <button type="button" onclick="hapusOpsi(this)" class="text-red-500 font-bold text-xs bg-red-100 px-3 py-1 rounded-full">Hapus</button>
                            </div>
                            <input type="text" name="teks_opsi[]" value="<?= esc($opsi['teks_opsi']) ?>" class="neu-pressed w-full px-5 py-3 rounded-xl focus:outline-none" required>
                            <textarea name="feedback_opsi[]" class="neu-pressed w-full p-3 rounded-xl focus:outline-none resize-none" required><?= esc($opsi['feedback_opsi']) ?></textarea>
                            <div class="flex items-center">
                                <label class="text-sm font-bold mr-3 text-gray-500">Skor (Positif/Negatif):</label>
                                <input type="number" name="skor_opsi[]" value="<?= esc($opsi['skor_opsi']) ?>" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none font-bold" required>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Tombol Tambah Opsi Dinamis -->
            <button type="button" onclick="tambahOpsi()" class="neu-btn-orange w-full text-white font-bold py-3 rounded-2xl transition">
                + Tambah Opsi Jawaban Lain
            </button>

            <!-- Tombol Submit -->
            <button type="submit" class="neu-btn-blue w-full text-white font-bold py-4 rounded-2xl transition mt-8 shadow-lg">
                Simpan Perubahan Skenario
            </button>
        </form>
    </div>

    <!-- Script Pembuat Opsi Dinamis (Sama dengan halaman Tambah) -->
    <script>
        function tambahOpsi() {
            const wadah = document.getElementById('wadah-opsi');
            const opsiBaru = document.createElement('div');
            opsiBaru.className = 'opsi-item neu-flat p-6 rounded-3xl space-y-4 mt-6';
            opsiBaru.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-bold text-gray-600 label-opsi">Opsi Jawaban Tambahan</h2>
                    <button type="button" onclick="hapusOpsi(this)" class="text-red-500 font-bold text-xs bg-red-100 px-3 py-1 rounded-full">Hapus</button>
                </div>
                <input type="text" name="teks_opsi[]" placeholder="Teks Pilihan Respons" class="neu-pressed w-full px-5 py-3 rounded-xl focus:outline-none" required>
                <textarea name="feedback_opsi[]" placeholder="Feedback CBT..." class="neu-pressed w-full p-3 rounded-xl focus:outline-none resize-none" required></textarea>
                <div class="flex items-center">
                    <label class="text-sm font-bold mr-3 text-gray-500">Skor (Positif/Negatif):</label>
                    <input type="number" name="skor_opsi[]" placeholder="Misal: -5, 0, atau 10" class="neu-pressed w-full px-4 py-3 rounded-xl focus:outline-none font-bold" required>
                </div>
            `;
            wadah.appendChild(opsiBaru);
        }

        function hapusOpsi(elemenBtn) {
            const wadah = document.getElementById('wadah-opsi');
            if (wadah.children.length > 1) {
                elemenBtn.closest('.opsi-item').remove();
            } else {
                alert('Skenario minimal harus memiliki 1 opsi jawaban!');
            }
        }
    </script>
</body>
</html>