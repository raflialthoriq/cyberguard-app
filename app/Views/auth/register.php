<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-green { background-color: #10B981; box-shadow: 4px 4px 8px rgba(16, 185, 129, 0.4), -4px -4px 8px rgba(255,255,255,1); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans text-gray-700 px-6 py-10">

    <div class="neu-flat p-8 rounded-[40px] w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-extrabold text-gray-800">Buat Akun Siswa</h1>
            <p class="text-xs text-gray-500 font-bold mt-1">Mulai perjalanan CBT kamu hari ini.</p>
        </div>

        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded-xl mb-4 text-xs font-bold text-center"><?= session()->getFlashdata('pesan_gagal') ?></div>
        <?php endif; ?>

        <form action="/auth/register_proses/siswa" method="POST" class="space-y-4">
            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>
            
            <input type="text" name="nama_panggilan" placeholder="Nama Panggilan" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>
            
    
<input type="email" name="email" placeholder="Pos-el" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>
            
            <input type="password" name="password" placeholder="Kata Sandi Baru" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>

           <!-- Dropdown Pilihan Sekolah Dinamis -->
            <select name="nama_sekolah" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none text-sm font-bold text-gray-500 bg-transparent" required>
                <option value="" disabled selected>-- Pilih Asal Sekolah --</option>
                <?php if(!empty($daftar_sekolah)): ?>
                    <?php foreach($daftar_sekolah as $sekolah): ?>
                        <option value="<?= esc($sekolah['nama_sekolah']) ?>"><?= esc($sekolah['nama_sekolah']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>Belum ada sekolah, hubungi Admin</option>
                <?php endif; ?>
            </select>
            
            <button type="submit" class="neu-btn-green w-full text-white font-bold py-4 rounded-2xl transition duration-300 mt-4">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 font-bold mt-8">
            Sudah punya akun? <a href="/auth" class="text-blue-500 hover:underline">Masuk sekarang</a>
        </p>
    </div>

</body>
</html>