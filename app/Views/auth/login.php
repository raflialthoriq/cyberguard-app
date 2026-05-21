<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .neu-btn-blue { background-color: #3B82F6; box-shadow: 4px 4px 8px rgba(59, 130, 246, 0.4), -4px -4px 8px rgba(255,255,255,1); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans text-gray-700 px-6">

    <div class="neu-flat p-8 rounded-[40px] w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-20 h-20 neu-flat rounded-full mx-auto flex items-center justify-center text-4xl mb-4 text-blue-500">🛡️</div>
            <h1 class="text-2xl font-extrabold text-gray-800">CyberGuard</h1>
            <p class="text-xs text-gray-500 font-bold mt-1">Aplikasi Pelatihan CBT Anti-Cyberbullying</p>
        </div>

        <?php if(session()->getFlashdata('pesan_gagal')): ?>
            <div class="bg-red-100 text-red-600 p-3 rounded-xl mb-4 text-xs font-bold text-center"><?= session()->getFlashdata('pesan_gagal') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('pesan_sukses')): ?>
            <div class="bg-green-100 text-green-600 p-3 rounded-xl mb-4 text-xs font-bold text-center"><?= session()->getFlashdata('pesan_sukses') ?></div>
        <?php endif; ?>

        <form action="/auth/login_proses" method="POST" class="space-y-6">
            <div>
                <input type="email" name="email" placeholder="Pos-el" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>
            </div>
            <div>
                <input type="password" name="password" placeholder="Kata Sandi" class="neu-pressed w-full px-5 py-4 rounded-2xl focus:outline-none" required>
            </div>
            
            <button type="submit" class="neu-btn-blue w-full text-white font-bold py-4 rounded-2xl transition duration-300">
                Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 font-bold mt-8">
            Belum punya akun? <a href="/auth/register" class="text-blue-500 hover:underline">Daftar di sini</a>
        </p>
        <p class="text-center text-xs text-gray-500 font-bold mt-3 border-t border-gray-300 pt-3">
             <a href="/auth/register_guru" class="text-green-600 hover:underline">Daftar sebagai Guru</a>
        </p>
        <p class="text-center text-xs text-gray-500 font-bold mt-4">
    <a href="/auth/lupa_password" class="text-red-500 hover:underline">Lupa Password?</a>
</p>
    </div>

</body>
</html>