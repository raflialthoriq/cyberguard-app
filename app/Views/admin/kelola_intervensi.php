<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Intervensi - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="p-6 font-sans container mx-auto lg:max-w-4xl min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-xl font-black text-gray-800">Audit & Moderasi Penjadwalan BK 🚨</h1>
            <p class="text-xs text-gray-500 font-bold">Otoritas tertinggi pembatalan/pengubahan janji konseling sekolah.</p>
        </div>
        <a href="/admin/beranda" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500">⬅️ Beranda</a>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-white p-4 rounded-xl mb-4 text-xs font-bold neu-flat text-blue-600 text-center"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <div class="space-y-4">
        <?php foreach($jadwal as $j): ?>
            <div class="neu-flat p-5 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-black text-indigo-600">[Siswa: <?= esc($j['nama_siswa']) ?>]</span>
                        <span class="text-[9px] uppercase font-black px-2 py-0.5 rounded <?= $j['status']=='direncanakan'?'bg-blue-100 text-blue-600':'bg-red-100 text-red-600' ?>"><?= $j['status'] ?></span>
                    </div>
                    <p class="text-xs font-bold text-gray-700 mt-1">Guru Pelaksana: <?= esc($j['nama_guru']) ?> (<?= esc($j['nama_sekolah']) ?>)</p>
                    <p class="text-[10px] text-gray-400 font-bold mt-0.5">Waktu Temu: <?= date('d M Y, H:i', strtotime($j['tanggal_konseling'])) ?> WIB | Catatan: <?= esc($j['catatan']) ?></p>
                </div>
                
                <?php if($j['status'] == 'direncanakan'): ?>
                    <div class="flex gap-2 w-full md:w-auto">
                        <form action="/admin/update_intervensi" method="POST" class="flex gap-1">
                            <input type="hidden" name="id_jadwal" value="<?= $j['id_jadwal'] ?>">
                            <input type="datetime-local" name="tanggal_konseling" class="text-[10px] p-1.5 bg-white rounded border focus:outline-none" required>
                            <input type="text" name="catatan" placeholder="Ubah lokasi" class="text-[10px] p-1.5 bg-white rounded border focus:outline-none" required>
                            <button type="submit" class="bg-blue-600 text-white text-[10px] font-bold px-3 rounded-lg shadow">Reschedule</button>
                        </form>
                        <a href="/admin/batal_intervensi/<?= $j['id_jadwal'] ?>" onclick="return confirm('Batalkan jadwal konseling ini?')" class="bg-red-100 text-red-600 font-bold text-[10px] px-3 py-2 rounded-lg text-center shadow-sm">Batalkan</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <th class="py-3 px-3">Guru BK</th>
<th class="py-3 px-3">Siswa & Kelas</th>
<th class="py-3 px-3">Status</th>
    </div>
</body>
</html>