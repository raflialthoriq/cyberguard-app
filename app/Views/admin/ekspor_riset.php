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

        <!-- ============================================================== -->
    <!-- DYNAMIC BOTTOM NAVIGATION BAR UNTUK HALAMAN ADMIN              -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-2 md:px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/admin/beranda" class="flex-1 flex flex-col items-center transition transform hover:-translate-y-1 text-gray-400"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🏠</span> <span class="text-[9px] md:text-[10px] font-extrabold truncate w-full">Beranda</span> </a>
            
            <a href="/admin/kelola_modul" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📚</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Modul</span> </a>
            
            <a href="/admin/kelola_simulasi" class="flex-1 flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🎮</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Simulasi</span> </a>

            <a href="/admin/kelola_kuesioner" class="flex-1 flex flex-col items-center text-gray-400 hover:text-teal-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">📝</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Kuesioner</span> </a>
            
            <!-- ================== MENU AKSES (DROPUP) ================== -->
            <div class="flex-1 relative flex flex-col items-center cursor-pointer group" onclick="document.getElementById('menuAkses').classList.toggle('hidden'); event.stopPropagation();">
                <span class="text-xl md:text-2xl mb-1 grayscale group-hover:grayscale-0 transition transform group-hover:-translate-y-1 text-gray-400 group-hover:text-indigo-500">🔐</span>
                
                <!-- Teks "Akses" dengan Ikon Panah Ke Atas -->
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full text-gray-400 group-hover:text-indigo-500 flex items-center justify-center gap-0.5">
                    Akses
                    <svg class="w-2.5 h-2.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7"></path>
                    </svg>
                </span>
                
                <!-- Popup Melayang -->
                <div id="menuAkses" class="hidden absolute bottom-full left-1/2 transform -translate-x-1/2 mb-3 bg-white rounded-2xl shadow-xl border border-gray-200 w-36 py-2 flex flex-col z-50 transition-all">
                    <!-- Segitiga penunjuk ke bawah -->
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-4 h-4 bg-white rotate-45 border-b border-r border-gray-200"></div>
                    
                    <a href="/admin/kelola_sekolah" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-green-600 hover:bg-green-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">🏫</span> Sekolah
                    </a>
                    <a href="/admin/manajemen_pengguna" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">👥</span> Pengguna
                    </a>
                    <a href="/admin/kelola_tips" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">💡</span> Afirmasi
                    </a>
                    <a href="/admin/kelola_panduan" class="flex items-center px-4 py-3 text-xs font-bold text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition border-b border-gray-100">
                        <span class="mr-3 text-lg">📚</span> Panduan 
                    </a>
                </div>
            </div>
            <!-- ========================================================= -->
            
            <a href="/admin/ekspor_riset" class="flex-1 flex flex-col items-center text-blue-600  hover:text-green-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 drop-shadow-md">📥</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Ekspor</span> </a>
            
            <a href="/profil" class="flex-1 flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1"> <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">👤</span> <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Profil</span> </a>
            
            <a href="/auth/logout" class="flex-1 flex flex-col items-center text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>
        </div>
    </nav>

    </body>
</html>