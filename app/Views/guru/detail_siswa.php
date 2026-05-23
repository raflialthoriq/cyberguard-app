<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rekam Jejak Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="p-6 font-sans container mx-auto lg:max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-black text-gray-800">Rekam Medis Pembelajaran Siswa 🎓</h1>
            <p class="text-xs text-blue-600 font-bold"><?= esc($siswa['nama_lengkap']) ?> (Skor Mental Health: <?= $siswa['skor_kesejahteraan'] ?> Poin)</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="neu-flat p-5 rounded-3xl">
            <h3 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Evaluasi Nilai Modul Belajar</h3>
            <div class="space-y-2">
                <?php foreach($progres as $p): ?>
                    <div class="neu-pressed p-3 rounded-xl text-xs flex justify-between items-center">
                        <span class="font-bold"><?= esc($p['judul_modul']) ?></span>
                        <span class="font-black text-blue-600"><?= $p['skor_kuis'] ?>%</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="neu-flat p-5 rounded-3xl">
            <h3 class="font-bold text-xs text-gray-400 uppercase tracking-wider mb-3">Keputusan Respon Skenario Simulasi</h3>
            <div class="space-y-2">
                <?php foreach($simulasi as $s): ?>
                    <div class="neu-pressed p-3 rounded-xl text-xs flex justify-between items-center">
                        <span class="font-bold"><?= esc($s['judul_skenario']) ?></span>
                        <span class="font-black <?= $s['skor_kontrol_diri']>0?'text-green-600':'text-red-500' ?>"><?= $s['skor_kontrol_diri']>0?'+':'' ?><?= $s['skor_kontrol_diri'] ?> Poin</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
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