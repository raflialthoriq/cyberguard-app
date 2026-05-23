<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);}</style>
</head>
<body class="p-6 font-sans container mx-auto lg:max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-black text-gray-800"><?= $judul ?> 📊</h1>
        <a href="/guru/beranda" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Beranda</a>
    </div>
    <div class="neu-flat p-5 rounded-3xl space-y-3">
        <?php foreach($siswa as $s): ?>
            <div class="bg-white/40 p-4 rounded-2xl flex justify-between items-center">
                <div>
                    <h4 class="font-bold text-sm text-gray-800"><?= esc($s['nama_lengkap']) ?></h4>
                    <p class="text-[10px] text-gray-500 font-medium">Wellbeing: <?= $s['skor_kesejahteraan'] ?> Poin | Login Terakhir: <?= $s['terakhir_login'] ?? 'Belum pernah' ?></p>
                </div>
                <a href="/guru/detail_siswa/<?= $s['id_pengguna'] ?>" class="bg-blue-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow">Detail Log</a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>