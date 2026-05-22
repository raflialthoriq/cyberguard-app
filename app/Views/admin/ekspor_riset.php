<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Riset - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body{background-color:#E0E5EC;} .neu-flat{box-shadow:7px 7px 14px rgb(163,177,198,0.6),-7px -7px 14px rgba(255,255,255,0.7);} .neu-pressed{box-shadow:inset 6px 6px 10px 0 rgba(163,177,198,0.7),inset -6px -6px 10px 0 #fff;}</style>
</head>
<body class="pb-32 font-sans text-gray-700 container mx-auto px-4 lg:max-w-4xl min-h-screen pt-8">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800">Ekspor Data Riset 📥</h1>
            <p class="text-sm font-bold text-gray-500">Unduh *dataset* anonim (CSV) untuk keperluan analisis statistik (SPSS/JASP).</p>
        </div>
        <a href="/admin/beranda" class="neu-flat px-4 py-2 rounded-xl text-xs font-bold text-gray-500 hover:text-gray-800">⬅️ Kembali</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        
        <div class="neu-flat p-6 rounded-3xl text-center flex flex-col items-center border-t-4 border-blue-400">
            <span class="text-5xl mb-4 drop-shadow-md">📚</span>
            <h2 class="font-extrabold text-gray-800 mb-2">Data Progres Modul</h2>
            <p class="text-[10px] font-bold text-gray-500 mb-6">Riwayat penyelesaian modul & skor kuis micro-learning.</p>
            <a href="/admin/unduh_csv/modul" class="w-full bg-blue-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-blue-600 transition active:scale-95 text-xs">Unduh CSV Modul</a>
        </div>

        <div class="neu-flat p-6 rounded-3xl text-center flex flex-col items-center border-t-4 border-orange-400">
            <span class="text-5xl mb-4 drop-shadow-md">🎮</span>
            <h2 class="font-extrabold text-gray-800 mb-2">Data Simulasi CBT</h2>
            <p class="text-[10px] font-bold text-gray-500 mb-6">Poin keputusan asertif/reaktif dari skenario *visual novel*.</p>
            <a href="/admin/unduh_csv/simulasi" class="w-full bg-orange-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-orange-600 transition active:scale-95 text-xs">Unduh CSV Simulasi</a>
        </div>

        <div class="neu-flat p-6 rounded-3xl text-center flex flex-col items-center border-t-4 border-purple-400">
            <span class="text-5xl mb-4 drop-shadow-md">📝</span>
            <h2 class="font-extrabold text-gray-800 mb-2">Data Kuesioner/SUS</h2>
            <p class="text-[10px] font-bold text-gray-500 mb-6">Jawaban instrumen Pre/Post-Test & pengukuran *Usability*.</p>
            <a href="/admin/unduh_csv/kuesioner" class="w-full bg-purple-500 text-white font-extrabold py-3 rounded-xl shadow-lg hover:bg-purple-600 transition active:scale-95 text-xs">Unduh CSV Kuesioner</a>
        </div>

    </div>

    <div class="mt-8 p-5 rounded-2xl neu-pressed border-l-4 border-gray-400">
        <p class="text-xs font-bold text-gray-500"><span class="text-gray-700 font-extrabold">Catatan Etika Penelitian:</span> Sesuai standar privasi, semua *file* CSV yang diekspor melalui halaman ini telah dianonimkan (Personally Identifiable Information seperti Nama dan Email dihapus dan diganti dengan ID Hash).</p>
    </div>

    </body>
</html>