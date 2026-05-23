<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 #fff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md neu-flat p-8 rounded-3xl border border-white/40">
        <div class="text-center mb-6">
            <h1 class="text-xl font-black text-gray-800">Pemulihan Akun 🔒</h1>
            <p class="text-xs font-bold text-gray-400 mt-1">Masukkan email terdaftar untuk mendapatkan instruksi tautan reset password.</p>
        </div>

        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-red-50 text-red-600 text-xs font-bold p-3 rounded-xl mb-4 text-center border border-red-200"><?= session()->getFlashdata('pesan_gagal') ?></div>
        <?php endif; ?>

        <form action="/auth/proses_lupa_password" method="POST" class="space-y-4">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-wider mb-1">Alamat Email Terdaftar</label>
                <input type="email" name="email" placeholder="contoh@sekolah.sch.id" class="w-full neu-pressed px-4 py-3 rounded-xl text-xs font-bold text-gray-700 focus:outline-none" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-extrabold py-3 rounded-xl text-xs shadow-md hover:bg-blue-700 transition active:scale-95">
                📧 Kirim Instruksi Reset
            </button>
        </form>
        <div class="text-center mt-6">
            <a href="/auth" class="text-xs font-bold text-gray-500 hover:text-blue-600 transition">⬅️ Kembali ke Halaman Masuk</a>
        </div>
    </div>
</body>
</html>