<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervensi Dini - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat { box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7); background-color: #E0E5EC; }
        .neu-pressed { box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1); background-color: #E0E5EC; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="pb-36 font-sans text-gray-700 container mx-auto px-4 lg:max-w-5xl min-h-screen pt-8 relative">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Intervensi & Penjadwalan 🚨</h1>
            <p class="text-xs font-bold text-gray-500 mt-1">Pantau siswa berisiko dan kelola agenda konseling BK.</p>
        </div>
    </div>

    <?php if(session()->getFlashdata('pesan')): ?>
        <div class="bg-white border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 text-xs font-bold neu-flat text-center"><?= session()->getFlashdata('pesan') ?></div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div>
            <h2 class="font-extrabold text-sm text-gray-800 mb-4 uppercase tracking-wider px-2">Siswa Butuh Perhatian</h2>
            <div class="space-y-4 max-h-[600px] overflow-y-auto hide-scrollbar pr-2">
                <?php foreach($daftar_flagged as $siswa): ?>
                    <div class="neu-flat p-5 rounded-3xl border-l-4 <?= $siswa['is_processed'] ? 'border-green-500' : ($siswa['keparahan'] == 'high' ? 'border-red-500' : 'border-yellow-500') ?>">
                        
                        <div class="mb-4">
                            <h3 class="font-black text-gray-800 text-sm"><?= esc($siswa['nama']) ?></h3>
                            <p class="text-[10px] font-bold text-gray-500 mt-0.5">Kelas: <?= esc($siswa['nama_kelas']) ?> | Email: <?= esc($siswa['email']) ?></p>
                            <p class="text-[10px] text-red-500 font-bold mt-1">Pemicu: <?= esc($siswa['alasan']) ?></p>
                        </div>
                        
                        <?php if($siswa['is_processed']): ?>
                            <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-xl text-center shadow-inner">
                                <span class="text-xs font-black text-green-600">✅ Sedang Ditindaklanjuti</span>
                                <p class="text-[9px] font-bold text-green-500 mt-1">Kamu telah menjadwalkan konseling untuk siswa ini. Evaluasi peringatan sistem akan direset otomatis pekan depan.</p>
                            </div>
                        <?php else: ?>
                            <form action="/guru/simpan_jadwal_konseling" method="POST" class="space-y-3 bg-white/20 p-4 rounded-2xl">
                                <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[9px] font-black text-gray-400 uppercase mb-1">Tanggal & Jam</label>
                                        <input type="datetime-local" name="tanggal_konseling" class="w-full text-[10px] font-bold text-gray-700 bg-white p-2 rounded-lg border focus:outline-none" required>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-gray-400 uppercase mb-1">Catatan Tempat</label>
                                        <input type="text" name="catatan" placeholder="Misal: Ruang BK" class="w-full text-[10px] font-bold text-gray-700 bg-white p-2 rounded-lg border focus:outline-none" required>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white font-extrabold py-2 rounded-xl text-xs shadow hover:bg-blue-700 transition active:scale-95">
                                    💾 Jadwalkan Konseling & Kirim Email
                                </button>
                            </form>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
                <?php if(empty($daftar_flagged)): ?>
                    <p class="text-center text-gray-400 font-bold text-sm py-8 neu-flat rounded-3xl">Semua siswa terpantau aman. Tidak ada yang memerlukan intervensi mendesak.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="neu-flat p-5 md:p-8 rounded-3xl h-fit">
            
            <?php 
                // Logika Navigasi Bulan
                $bln_aktif = isset($_GET['bln']) ? $_GET['bln'] : date('m');
                $thn_aktif = isset($_GET['thn']) ? $_GET['thn'] : date('Y');
                
                // Kalkulasi Bulan Sebelumnya & Selanjutnya
                $prev_bln = $bln_aktif - 1; $prev_thn = $thn_aktif;
                if($prev_bln == 0) { $prev_bln = 12; $prev_thn--; }
                
                $next_bln = $bln_aktif + 1; $next_thn = $thn_aktif;
                if($next_bln == 13) { $next_bln = 1; $next_thn++; }

                $nama_bulan_aktif = date('F Y', strtotime("$thn_aktif-$bln_aktif-01"));
            ?>

            <div class="mb-6 border-b pb-2 flex justify-between items-center">
                <h3 class="font-extrabold text-sm text-gray-800 uppercase tracking-wider flex items-center gap-2">
                    📅 Agenda
                </h3>
                <div class="flex items-center gap-3 bg-white px-3 py-1.5 rounded-xl shadow-sm border border-gray-200">
                    <a href="?bln=<?= sprintf('%02d', $prev_bln) ?>&thn=<?= $prev_thn ?>" class="text-gray-400 hover:text-blue-600 font-bold transition">◀</a>
                    <span class="text-blue-600 font-black text-xs w-24 text-center"><?= $nama_bulan_aktif ?></span>
                    <a href="?bln=<?= sprintf('%02d', $next_bln) ?>&thn=<?= $next_thn ?>" class="text-gray-400 hover:text-blue-600 font-bold transition">▶</a>
                </div>
            </div>
            
            <div class="grid grid-cols-7 gap-1 md:gap-2 text-center text-[10px] font-black uppercase text-gray-400 mb-2">
                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
            </div>
            
            <div class="grid grid-cols-7 gap-1 md:gap-2 text-center font-bold text-xs md:text-sm">
                <?php 
                $jumlah_hari = date('t', strtotime("$thn_aktif-$bln_aktif-01"));
                $hari_pertama = date('w', strtotime("$thn_aktif-$bln_aktif-01"));
                $hari_ini_nyata = date('d');
                $bulan_ini_nyata = date('m');

                // Pemetaan Jadwal
                $map_alasan = [];
                foreach($daftar_flagged as $f) $map_alasan[$f['id_siswa']] = $f['alasan'];

                $jadwal_per_tanggal = [];
                foreach($daftar_jadwal as $j) {
                    $tgl = date('j', strtotime($j['tanggal_konseling']));
                    $bln = date('m', strtotime($j['tanggal_konseling']));
                    $thn = date('Y', strtotime($j['tanggal_konseling']));
                    
                    // Cek apakah jadwal ini jatuh pada bulan yang sedang dilihat
                    if($bln == $bln_aktif && $thn == $thn_aktif) {
                        $j['alasan_flag'] = isset($map_alasan[$j['id_siswa']]) ? $map_alasan[$j['id_siswa']] : 'Pemantauan lanjutan / Manual';
                        if(!isset($jadwal_per_tanggal[$tgl])) $jadwal_per_tanggal[$tgl] = [];
                        $jadwal_per_tanggal[$tgl][] = $j;
                    }
                }

                // Render Offset & Tanggal
                for($i = 0; $i < $hari_pertama; $i++) echo '<div class="p-2 md:p-3 opacity-0"></div>';

                for($d = 1; $d <= $jumlah_hari; $d++) {
                    $has_agenda = isset($jadwal_per_tanggal[$d]);
                    $is_today = ($d == $hari_ini_nyata && $bln_aktif == $bulan_ini_nyata && $thn_aktif == date('Y'));
                    
                    if($is_today) $bg_class = 'bg-blue-600 text-white shadow-lg transform scale-105';
                    elseif($has_agenda) $bg_class = 'bg-orange-100 text-orange-600 border border-orange-300 cursor-pointer hover:bg-orange-200 transition transform hover:-translate-y-1 hover:shadow-md';
                    else $bg_class = 'neu-pressed text-gray-700';

                    $data_json = $has_agenda ? htmlspecialchars(json_encode($jadwal_per_tanggal[$d])) : '[]';

                    echo '<div class="p-2 md:p-3 rounded-xl flex flex-col items-center justify-center min-h-[45px] md:min-h-[60px] ' . $bg_class . '" ';
                    if($has_agenda) echo 'onclick="bukaDetailJadwal(' . $data_json . ', ' . $d . ')"';
                    echo '>';
                    echo '<span>' . $d . '</span>';
                    if($has_agenda) echo '<div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-orange-500 rounded-full mt-1 shadow-sm"></div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <div id="modalJadwal" class="fixed inset-0 z-[60] bg-gray-900/40 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-all">
        <div class="bg-[#E0E5EC] w-full max-w-md rounded-3xl shadow-2xl border border-white overflow-hidden transform scale-100 transition-transform">
            
            <div class="bg-white px-6 py-4 border-b flex justify-between items-center">
                <div>
                    <h3 id="judulModalJadwal" class="font-black text-gray-800 text-lg">Jadwal Tanggal</h3>
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Detail Agenda Konseling</p>
                </div>
                <button onclick="tutupModal()" class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 font-bold hover:bg-red-100 hover:text-red-600 transition">&times;</button>
            </div>

            <div id="kontenJadwal" class="p-6 max-h-[60vh] overflow-y-auto space-y-4">
                </div>
            
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50 shadow-[0_-10px_25px_rgba(163,177,198,0.4)]">
        <div class="max-w-5xl mx-auto px-2 py-3 flex justify-between items-center text-center">
            <a href="/guru/beranda" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">📊</span> <span class="text-[9px] font-bold">Dasbor</span> </a>
            <a href="/guru/manajemen_kelas" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">👥</span> <span class="text-[9px] font-bold">Kelas</span> </a>
            <a href="/guru/intervensi_dini" class="flex-1 flex flex-col items-center text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg drop-shadow-md">🚨</span> <span class="text-[9px] font-black">Intervensi</span> </a>
            <a href="/guru/panduan_fasilitator" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">📚</span> <span class="text-[9px] font-bold">Panduan</span> </a>
            <a href="/guru/laporan_cepat" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">📄</span> <span class="text-[9px] font-bold">Laporan</span> </a>
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">👤</span> <span class="text-[9px] font-bold">Profil</span> </a>
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1"> <span class="text-lg grayscale hover:grayscale-0">🚪</span> <span class="text-[9px] font-bold">Keluar</span> </a>
        </div>
    </nav>

    <script>
        function bukaDetailJadwal(dataJadwal, tanggal) {
            const modal = document.getElementById('modalJadwal');
            const konten = document.getElementById('kontenJadwal');
            const judul = document.getElementById('judulModalJadwal');
            
            // Atur Judul Berdasarkan Tanggal yang Diklik
            const namaBulan = new Date().toLocaleString('id-ID', { month: 'long', year: 'numeric' });
            judul.innerText = `Jadwal: ${tanggal} ${namaBulan}`;
            
            // Kosongkan isi konten sebelumnya
            konten.innerHTML = '';
            
            // Iterasi data jadwal dan buat kartu untuk masing-masing jadwal
            dataJadwal.forEach(j => {
                // Ekstrak Jam dan Menit
                let waktuDate = new Date(j.tanggal_konseling);
                let jam = waktuDate.getHours().toString().padStart(2, '0');
                let menit = waktuDate.getMinutes().toString().padStart(2, '0');
                
                let bgColor = j.status === 'direncanakan' ? 'bg-blue-50 border-blue-500' : (j.status === 'selesai' ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500');
                let badgeColor = j.status === 'direncanakan' ? 'bg-blue-100 text-blue-700' : (j.status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700');

                let cardHTML = `
                    <div class="${bgColor} border-l-4 p-4 rounded-xl shadow-sm relative overflow-hidden">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-black text-gray-800 text-base">⏰ ${jam}:${menit} WIB</h4>
                            <span class="px-2 py-1 ${badgeColor} text-[9px] rounded font-black uppercase tracking-widest">${j.status}</span>
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-500">Siswa Bimbingan:</p>
                            <p class="text-sm font-black text-gray-800 mb-2">${j.nama_lengkap}</p>
                            
                            <p class="text-xs font-bold text-gray-500">Tempat / Catatan:</p>
                            <p class="text-xs font-bold text-indigo-600 mb-2">📍 ${j.catatan}</p>
                            
                            <div class="mt-3 bg-white p-3 rounded-lg border border-red-100">
                                <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Pemicu Intervensi:</p>
                                <p class="text-xs font-bold text-red-600 leading-snug">${j.alasan_flag}</p>
                            </div>
                        </div>
                    </div>
                `;
                konten.innerHTML += cardHTML;
            });
            
            // Tampilkan Modal
            modal.classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('modalJadwal').classList.add('hidden');
        }

        // Tutup modal jika user mengklik area abu-abu di luar modal
        document.getElementById('modalJadwal').addEventListener('click', function(e) {
            if(e.target === this) {
                tutupModal();
            }
        });
    </script>
</body>
</html>