<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
    </style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-3xl relative min-h-screen">
    
    <div class="mt-8 mb-6 text-center">
        <h1 class="text-2xl font-extrabold text-gray-800">Profil Saya</h1>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6 text-sm font-bold text-center neu-flat">
            ✅ <?= session()->getFlashdata('pesan') ?>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('pesan_gagal')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 text-sm font-bold text-center neu-flat">
            ❌ <?= session()->getFlashdata('pesan_gagal') ?>
        </div>
    <?php endif; ?>

    <div class="neu-flat p-6 md:p-8 rounded-3xl mb-8">
        <!-- FOTO PROFIL -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-32 h-32 rounded-full neu-pressed mb-3 overflow-hidden flex items-center justify-center border-4 border-[#E0E5EC]">
                <?php if(!empty($user['url_avatar'])): ?>
                    <img id="avatarPreview" src="/<?= $user['url_avatar'] ?>" alt="Avatar" class="w-full h-full object-cover">
                <?php else: ?>
                    <span class="text-4xl text-gray-400">👤</span>
                <?php endif; ?>
            </div>
            
            <label id="btnGantiFoto" class="hidden neu-flat px-4 py-2 rounded-full text-xs font-bold text-blue-600 cursor-pointer hover:text-blue-800 transition">
                📷 Ubah Foto
                <input type="file" id="inputFoto" accept="image/*" class="hidden" onchange="bukaCropper(event)">
            </label>
        </div>

        <form id="formProfil" action="/profil/update" method="POST">
            <input type="hidden" name="avatar_base64" id="avatar_base64">

            <!-- Data Tampil Bersih (Readonly Style) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4 mb-5">
                <div class="md:col-span-2">
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">Nama Sekolah</label>
                    <input type="text" value="<?= esc($user['nama_sekolah'] ?? 'Tidak Terikat Sekolah') ?>" class="w-full bg-transparent border-b-2 border-gray-300 py-2 focus:outline-none text-sm font-bold text-gray-400 cursor-not-allowed" readonly>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>" class="input-data w-full bg-transparent border-b-2 border-dashed border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 transition-all duration-300" readonly required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">Nama Panggilan</label>
                    <input type="text" name="nama_panggilan" value="<?= esc($user['nama_panggilan']) ?>" class="input-data w-full bg-transparent border-b-2 border-dashed border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 transition-all duration-300" readonly required>
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">Pos-el (Email)</label>
                <input type="email" name="email" value="<?= esc($user['email']) ?>" class="input-data w-full bg-transparent border-b-2 border-dashed border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 transition-all duration-300" readonly required>
            </div>

            <?php if($user['peran'] !== 'siswa'): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4 mb-5">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">NIP</label>
                    <input type="text" name="nip" value="<?= esc($user['nip']) ?>" class="input-data w-full bg-transparent border-b-2 border-dashed border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 transition-all duration-300" readonly>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-1">Jabatan</label>
                    <input type="text" name="jabatan" value="<?= esc($user['jabatan']) ?>" class="input-data w-full bg-transparent border-b-2 border-dashed border-gray-400 py-2 focus:outline-none text-sm font-bold text-gray-800 transition-all duration-300" readonly>
                </div>
            </div>
            <?php endif; ?>

            <!-- Area Kata Sandi (Hanya muncul di Mode Edit) -->
            <div id="areaSandi" class="hidden pt-6 border-t border-gray-300/50 mt-6">
                <p class="text-xs font-bold text-orange-500 mb-4 bg-orange-100 p-3 rounded-lg border-l-4 border-orange-500">Kosongkan kolom di bawah ini jika tidak ingin mengubah kata sandi.</p>
                <div class="space-y-4">
                    <div class="relative">
                        <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-2">Kata Sandi LAMA</label>
                        <input type="password" id="sandiLama" name="kata_sandi_lama" placeholder="Ketik kata sandi saat ini" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700 pr-12">
                        <button type="button" onclick="toggleSandi('sandiLama')" class="absolute right-4 top-8 text-xl text-gray-400 hover:text-blue-500">👁️</button>
                    </div>
                    <div class="relative">
                        <label class="block text-[10px] uppercase tracking-widest font-extrabold text-gray-400 mb-2">Kata Sandi BARU</label>
                        <input type="password" id="sandiBaru" name="kata_sandi_baru" placeholder="Minimal 8 karakter (Huruf besar, kecil, angka, simbol)" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-sm font-bold text-gray-700 pr-12">
                        <button type="button" onclick="toggleSandi('sandiBaru')" class="absolute right-4 top-8 text-xl text-gray-400 hover:text-blue-500">👁️</button>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex gap-4">
                <button type="button" id="btnEdit" onclick="aktifkanEdit()" class="w-full neu-pressed text-blue-600 font-extrabold py-3 rounded-xl hover:text-blue-800 transition active:scale-95 text-sm">
                    ✏️ Edit Profil
                </button>
                <button type="submit" id="btnSimpan" class="hidden w-full bg-green-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-green-600 transition active:scale-95 text-sm">
                    💾 Simpan Perubahan
                </button>
                <button type="button" id="btnBatal" onclick="batalkanEdit()" class="hidden w-full neu-flat text-red-500 font-extrabold py-3 rounded-xl hover:text-red-700 transition active:scale-95 text-sm">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Popup Cropper -->
    <div id="cropperModal" class="hidden fixed inset-0 bg-black/80 z-[100] flex items-center justify-center p-4">
        <div class="bg-[#E0E5EC] w-full max-w-md rounded-3xl p-6">
            <h3 class="font-extrabold text-gray-800 mb-4">Atur Posisi Foto</h3>
            <div class="w-full h-64 bg-gray-200 mb-4 rounded-xl overflow-hidden">
                <img id="imageToCrop" src="" alt="Gambar untuk dicrop">
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="tutupCropper()" class="w-1/2 neu-flat text-gray-600 font-bold py-3 rounded-xl active:scale-95 text-sm">Batal</button>
                <button type="button" onclick="terapkanCrop()" class="w-1/2 bg-blue-500 text-white font-bold py-3 rounded-xl active:scale-95 text-sm">Pilih Foto</button>
            </div>
        </div>
    </div>

    <!-- SCRIPT LOGIKA UI -->
    <script>
        const inputs = document.querySelectorAll('.input-data');
        const btnEdit = document.getElementById('btnEdit');
        const btnSimpan = document.getElementById('btnSimpan');
        const btnBatal = document.getElementById('btnBatal');
        const areaSandi = document.getElementById('areaSandi');
        const btnGantiFoto = document.getElementById('btnGantiFoto');

        function aktifkanEdit() {
            inputs.forEach(input => {
                input.removeAttribute('readonly');
                input.classList.remove('bg-transparent', 'border-b-2', 'border-dashed', 'border-gray-400', 'py-2');
                input.classList.add('neu-pressed', 'rounded-xl', 'px-4', 'py-3');
            });
            btnEdit.classList.add('hidden');
            btnSimpan.classList.remove('hidden');
            btnBatal.classList.remove('hidden');
            areaSandi.classList.remove('hidden');
            btnGantiFoto.classList.remove('hidden');
        }

        function batalkanEdit() {
            inputs.forEach(input => {
                input.setAttribute('readonly', 'true');
                input.classList.add('bg-transparent', 'border-b-2', 'border-dashed', 'border-gray-400', 'py-2');
                input.classList.remove('neu-pressed', 'rounded-xl', 'px-4', 'py-3');
            });
            btnEdit.classList.remove('hidden');
            btnSimpan.classList.add('hidden');
            btnBatal.classList.add('hidden');
            areaSandi.classList.add('hidden');
            btnGantiFoto.classList.add('hidden');
            document.getElementById('formProfil').reset();
        }

        function toggleSandi(id) {
            const inputSandi = document.getElementById(id);
            inputSandi.type = inputSandi.type === 'password' ? 'text' : 'password';
        }

        // Logika Cropper (Sama seperti sebelumnya)
        let cropper;
        const imageToCrop = document.getElementById('imageToCrop');
        const cropperModal = document.getElementById('cropperModal');

        function bukaCropper(event) {
            const files = event.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imageToCrop.src = e.target.result;
                    cropperModal.classList.remove('hidden');
                    if (cropper) { cropper.destroy(); }
                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1, viewMode: 1, dragMode: 'move', autoCropArea: 1,
                        restore: false, guides: false, center: false, highlight: false,
                        cropBoxMovable: true, cropBoxResizable: false, toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(files[0]);
            }
        }

        function tutupCropper() {
            cropperModal.classList.add('hidden');
            document.getElementById('inputFoto').value = ''; 
        }

        function terapkanCrop() {
            const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
            const base64data = canvas.toDataURL('image/png');
            document.getElementById('avatar_base64').value = base64data;
            document.getElementById('avatarPreview').src = base64data;
            tutupCropper();
        }
    </script>

    <!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN PROFIL             -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <?php 
            // Pengaman: Ubah peran dari database menjadi huruf kecil semua
            $peran_akun = strtolower($user['peran']); 
            ?>

            <?php if($peran_akun === 'siswa'): ?>
                <!-- ================== NAVIGASI SISWA ================== -->
                <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span> </a>
                
                <a href="/siswa/modul" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Belajar</span> </a>
                
                <a href="/siswa/simulasi" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Latihan</span> </a>
                
                <a href="/siswa/jurnal" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📔</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Jurnal</span> </a>
                
                <!-- Menu Profil (AKTIF - Menyala Biru) -->
                <a href="/profil" class="flex flex-col items-center text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">👤</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Profil</span> </a>
                
                <a href="/auth/logout" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span> </a>


            <?php elseif($peran_akun === 'guru'): ?>
                <!-- ================== NAVIGASI GURU ================== -->
                <a href="/guru/beranda" class="flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📊</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Beranda</span> </a>
                
                <a href="/guru/manajemen_kelas" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kelas</span> </a>
                
                <a href="/guru/intervensi_dini" class="flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚨</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Intervensi</span> </a>
                
                <a href="/guru/panduan_fasilitator" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Panduan</span> </a>
                
                <a href="/guru/laporan_cepat" class="flex flex-col items-center text-gray-400 hover:text-purple-500 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📄</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Laporan</span> </a>
                
                <!-- Menu Profil (AKTIF - Menyala Biru) -->
                <a href="/profil" class="flex flex-col items-center text-blue-600 transition transform hover:-translate-y-1 w-1/6"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">👤</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Profil</span> </a>
                <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>


            <?php else: ?>
                <!-- ================== NAVIGASI ADMIN ================== -->
                <!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
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
            
            <a href="/profil" class="flex-1 flex flex-col items-center text-blue-600 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            
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

            <?php endif; ?>
            
        </div>
    </nav>

</body>
</html>