<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="pb-36 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Manajemen Ruang Kelas 👥</h1>
            <p class="text-xs font-bold text-gray-500 mt-1">Kontrol penuh validitas rute kode undangan bimbingan.</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-white border-l-4 border-blue-500 text-blue-700 p-4 rounded-xl mb-6 text-xs font-bold neu-flat text-center"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="neu-flat p-6 rounded-3xl h-fit">
            <h2 class="font-extrabold text-sm text-gray-800 mb-4 uppercase tracking-wider border-b pb-2">Buat Kelas Baru</h2>
            <form action="/guru/simpan_kelas" method="POST">
                <input type="text" name="nama_kelas" placeholder="Contoh: XII-RPL-1" class="w-full neu-pressed px-4 py-3 rounded-xl focus:outline-none text-xs font-bold text-gray-700 mb-4" required>
                <button type="submit" class="w-full bg-blue-600 text-white font-extrabold py-3 rounded-xl text-xs shadow-md transition active:scale-95">➕ Terbitkan Kelas</button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-extrabold text-sm text-gray-800 mb-2 uppercase tracking-wider px-2">Daftar Kelas Bimbingan Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach($daftar_kelas as $k): ?>
                    <div class="neu-flat p-5 rounded-3xl flex flex-col justify-between border border-white/40">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-black text-gray-800 text-base"><?= esc($k['nama_kelas']) ?></h3>
                                <p class="text-[10px] font-bold text-gray-400 mt-0.5">Siswa: <?= $k['jumlah_siswa'] ?> Orang</p>
                            </div>
                            <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded <?= $k['status_kelas']=='buka' ? 'bg-green-100 text-green-600':'bg-red-100 text-red-600' ?>"><?= $k['status_kelas'] ?></span>
                        </div>

                        <div class="my-4 neu-pressed p-3 rounded-2xl flex justify-between items-center bg-gray-50/10">
                            <span class="text-[10px] font-mono tracking-widest font-black text-blue-600"><?= esc($k['kode_kelas']) ?></span>
                            <?php if($k['status_kelas'] == 'buka'): ?>
                                <a href="/guru/refresh_kode_kelas/<?= $k['id_kelas'] ?>" class="text-[9px] bg-white text-gray-600 px-2 py-1 rounded-lg font-bold shadow-sm hover:bg-gray-100">🔄 Acak Kode</a>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-3 pt-2 border-t border-gray-300/40">
                            <div class="flex justify-between text-[10px] font-bold">
                                <span class="text-gray-400">Rata-rata Progres:</span>
                                <span class="text-gray-700"><?= $k['rata_progres'] ?>%</span>
                            </div>
                            <div class="w-full bg-gray-300 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-indigo-500 h-1.5" style="width: <?= $k['rata_progres'] ?>%"></div>
                            </div>
                            <div class="flex gap-2 pt-1">
                                <a href="/guru/detail_kelas/<?= $k['id_kelas'] ?>" class="w-1/2 text-center bg-indigo-600 text-white font-bold py-2 rounded-xl text-[10px] shadow">👤 Kelola Murid</a>
                                <a href="/guru/tutup_kelas/<?= $k['id_kelas'] ?>" class="w-1/2 text-center text-xs font-bold py-2 rounded-xl text-[10px] border border-gray-400/50 <?= $k['status_kelas']=='buka'?'text-red-600 bg-red-50/20':'text-green-600 bg-green-50/20' ?>"><?= $k['status_kelas']=='buka'?'🔒 Tutup Kelas':'🔓 Buka Kelas' ?></a>
                            </div>
                        </div>
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