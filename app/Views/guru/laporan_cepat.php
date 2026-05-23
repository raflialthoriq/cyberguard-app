<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi BK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="pb-36 font-sans container mx-auto px-4 lg:max-w-6xl min-h-screen pt-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-800">Laporan & Evaluasi 📄</h1>
            <p class="text-xs text-gray-500 font-bold mt-1">Sajian data analitik akurat berdasarkan relasi bimbingan kelas Anda.</p>
        </div>
        <a href="/guru/beranda" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Beranda</a>
    </div>

    <div class="neu-flat p-6 rounded-3xl mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <form action="" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <select name="kelas" class="neu-pressed px-4 py-2 rounded-xl text-xs font-bold text-gray-700 outline-none">
                <option value="">Semua Kelas</option>
                <?php foreach($daftar_kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>" <?= $filter_kelas == $k['id_kelas'] ? 'selected' : '' ?>><?= esc($k['nama_kelas']) ?></option>
                <?php endforeach; ?>
            </select>
            <input type="month" name="waktu" value="<?= esc($filter_waktu) ?>" class="neu-pressed px-4 py-2 rounded-xl text-xs font-bold text-gray-700 outline-none">
            <button type="submit" class="bg-blue-600 text-white font-bold px-4 py-2 rounded-xl text-xs shadow hover:bg-blue-700">🔍 Filter Data</button>
        </form>

        <div class="flex gap-2 w-full md:w-auto">
            <a href="/guru/ekspor_laporan/pdf" target="_blank" class="flex-1 text-center bg-red-100 text-red-600 font-black px-4 py-2 rounded-xl text-xs border border-red-200">📄 PDF</a>
            <a href="/guru/ekspor_laporan/excel" class="flex-1 text-center bg-green-100 text-green-700 font-black px-4 py-2 rounded-xl text-xs border border-green-200">📊 Excel</a>
            <a href="/guru/ekspor_laporan/csv" class="flex-1 text-center bg-gray-200 text-gray-700 font-black px-4 py-2 rounded-xl text-xs border border-gray-300">📉 CSV</a>
        </div>
    </div>

    <div class="neu-flat p-6 rounded-3xl overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b-2 border-gray-300">
                    <th class="py-3 px-3">Nama Siswa</th>
                    <th class="py-3 px-3">Kesejahteraan</th>
                    <th class="py-3 px-3 text-center">Modul Tuntas</th>
                    <th class="py-3 px-3 text-center">Nilai CBT</th>
                    <th class="py-3 px-3">Login Terakhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($laporan as $s): ?>
                <tr class="border-b border-gray-300/40 hover:bg-white/30 transition">
                    <td class="py-4 px-3">
                        <p class="font-black text-gray-800 text-xs"><?= esc($s['nama']) ?></p>
                        <p class="text-[9px] font-bold text-gray-500"><?= esc($s['email']) ?></p>
                    </td>
                    <td class="py-4 px-3"><span class="font-black <?= $s['skor_mental'] >= 50 ? 'text-green-500':'text-red-500' ?>"><?= $s['skor_mental'] ?> Poin</span></td>
                    <td class="py-4 px-3 text-center text-xs font-bold text-gray-700"><?= $s['modul_selesai'] ?> Bab <span class="text-blue-500">(Avg: <?= $s['rata_kuis'] ?>%)</span></td>
                    <td class="py-4 px-3 text-center text-xs font-black text-indigo-600"><?= $s['poin_cbt'] ?> Poin</td>
                    <td class="py-4 px-3 text-[10px] font-bold text-gray-500"><?= $s['login_terakhir'] ? date('d M Y, H:i', strtotime($s['login_terakhir'])) : 'Belum' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50 shadow-2xl">
        <div class="max-w-5xl mx-auto px-2 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">📊</span> <span class="text-[9px] font-bold">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">      👥</span> <span class="text-[9px] font-bold">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">🚨</span> <span class="text-[9px] font-bold">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">📚</span> <span class="text-[9px] font-bold">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex-1 flex flex-col items-center text-blue-600"> <span class="text-lg">📄</span> <span class="text-[9px] font-black">Laporan</span> </a>
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">👤</span> <span class="text-[9px] font-bold">Profil</span> </a>
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400"> <span class="text-lg">🚪</span> <span class="text-[9px] font-bold">Keluar</span> </a>
        </div>
    </nav>
</body>
</html>