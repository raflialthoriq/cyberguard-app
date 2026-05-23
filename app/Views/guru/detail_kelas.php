<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);}</style>
</head>
<body class="pb-36 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-800">Kelas: <?= esc($kelas['nama_kelas']) ?></h1>
            <p class="text-xs font-bold text-gray-500">Daftar siswa bimbingan aktif di dalam rombel ini.</p>
        </div>
        <a href="/guru/manajemen_kelas" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Kembali</a>
    </div>

    <div class="neu-flat p-6 rounded-3xl overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-xs uppercase tracking-widest text-gray-400 border-b-2 border-gray-300">
                    <th class="py-3 px-4">Nama Lengkap</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Skor Mental Health</th>
                    <th class="py-3 px-4 text-center">Aksi Log</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($daftar_siswa as $s): ?>
                <tr class="border-b border-gray-300/50 hover:bg-white/30 transition">
                    <td class="py-4 px-4 font-bold text-gray-800"><?= esc($s['nama_lengkap']) ?></td>
                    <td class="py-4 px-4 text-xs font-semibold text-gray-500"><?= esc($s['email']) ?></td>
                    <td class="py-4 px-4"><span class="font-black <?= $s['skor_kesejahteraan'] >= 50 ? 'text-green-600' : 'text-red-500' ?>"><?= $s['skor_kesejahteraan'] ?> Poin</span></td>
                    <td class="py-4 px-4 text-center"><a href="/guru/detail_siswa/<?= $s['id_pengguna'] ?>" class="bg-blue-600 text-white font-bold text-xs px-3 py-1.5 rounded-xl shadow-md">Buka Rekam Jejak</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50 shadow-2xl">
        <div class="max-w-5xl mx-auto px-2 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">📊</span> <span class="text-[9px] font-bold">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex-1 flex flex-col items-center text-blue-600"> <span class="text-lg">👥</span> <span class="text-[9px] font-black">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">🚨</span> <span class="text-[9px] font-bold">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">📚</span> <span class="text-[9px] font-bold">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">📄</span> <span class="text-[9px] font-bold">Laporan</span> </a>
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">👤</span> <span class="text-[9px] font-bold">Profil</span> </a>
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">🚪</span> <span class="text-[9px] font-bold">Keluar</span> </a>
        </div>
    </nav>
</body>
</html>