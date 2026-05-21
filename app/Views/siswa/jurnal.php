<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Diary - CyberGuard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #E0E5EC; }
        .neu-flat {
            background-color: #E0E5EC;
            box-shadow: 7px 7px 14px rgb(163,177,198,0.6), -7px -7px 14px rgba(255,255,255,0.7);
        }
        .neu-pressed {
            background-color: #E0E5EC;
            box-shadow: inset 6px 6px 10px 0 rgba(163,177,198,0.7), inset -6px -6px 10px 0 rgba(255,255,255,1);
        }
        .neu-btn-orange {
            background-color: #F97316;
            box-shadow: 6px 6px 10px rgba(249, 115, 22, 0.4), -6px -6px 10px rgba(255,255,255,1);
        }
        .neu-btn-orange:active {
            box-shadow: inset 4px 4px 8px rgba(194, 65, 12, 0.6), inset -4px -4px 8px rgba(251, 146, 60, 0.5);
        }
        
        /* Modifikasi Radio Button Emoji untuk Neumorphism */
        input[type="radio"] { display: none; }
        .emoji-label { transition: all 0.2s ease; }
        input[type="radio"]:checked + .emoji-label {
            box-shadow: inset 4px 4px 8px rgba(163,177,198,0.7), inset -4px -4px 8px rgba(255,255,255,1);
            transform: scale(0.95);
        }
    </style>
</head>

<!-- ============================================================== -->
    <!-- BOTTOM NAVIGATION BAR (JURNAL AKTIF)                           -->
    <!-- ============================================================== -->
    <nav class="fixed bottom-0 left-0 w-full bg-[#E0E5EC] rounded-t-3xl border-t border-white/50 z-50" style="box-shadow: 0 -10px 25px rgba(163,177,198,0.4);">
        <div class="max-w-5xl mx-auto px-6 py-3 flex justify-between items-center text-center">
            
            <a href="/siswa/beranda" class="flex flex-col items-center text-gray-400 hover:text-blue-600 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">🏠</span>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>
            
            <a href="/siswa/modul" class="flex flex-col items-center text-gray-400 hover:text-teal-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">📚</span>
                <span class="text-[10px] font-bold">Belajar</span>
            </a>
            
            <a href="/siswa/simulasi" class="flex flex-col items-center text-gray-400 hover:text-orange-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">🎮</span>
                <span class="text-[10px] font-bold">Latihan</span>
            </a>
            
            <a href="/siswa/jurnal" class="flex flex-col items-center text-purple-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 drop-shadow-md">📔</span>
                <span class="text-[10px] font-extrabold">Jurnal</span>
            </a>
            
            <a href="/profil" class="flex flex-col items-center text-gray-400 hover:text-blue-500 transition transform hover:-translate-y-1">
                <span class="text-2xl mb-1 grayscale hover:grayscale-0">👤</span>
                <span class="text-[10px] font-bold">Profil</span>
            </a>
            <a href="/auth/logout" class="flex flex-col items-center w-1/6 text-gray-400 hover:text-red-500 transition transform hover:-translate-y-1">
                <span class="text-xl md:text-2xl mb-1 grayscale hover:grayscale-0">🚪</span>
                <span class="text-[9px] md:text-[10px] font-bold truncate w-full">Keluar</span>
            </a>

        </div>
    </nav>

<body class="flex flex-col h-screen font-sans text-gray-700 pb-28">

    <!-- Header -->
    <div class="p-6 flex items-center justify-between">
        <a href="/siswa/beranda" class="neu-flat w-10 h-10 flex items-center justify-center rounded-full text-blue-600 font-bold active:neu-pressed">←</a>
        <h1 class="text-lg font-extrabold text-gray-700 uppercase tracking-wider">Personal Journal</h1>
        <div class="w-10"></div> <!-- Spacer -->
    </div>

    <!-- Area Konten Form -->
    <div class="flex-1 px-6 pb-6 flex flex-col">
        <form action="/siswa/jurnal/simpan" method="POST" class="h-full flex flex-col">
            
            <div class="text-center mb-8 neu-flat p-6 rounded-3xl">
                <h2 class="text-lg font-bold text-gray-700 mb-6">Bagaimana perasaanmu siang ini?</h2>
                
                <div class="flex justify-center space-x-6">
                    <div>
                        <input type="radio" id="mood_sedih" name="suasana_hati" value="sedih" required>
                        <label for="mood_sedih" class="emoji-label neu-flat cursor-pointer inline-block w-16 h-16 flex items-center justify-center rounded-full text-3xl">
                            😢
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="mood_biasa" name="suasana_hati" value="biasa">
                        <label for="mood_biasa" class="emoji-label neu-flat cursor-pointer inline-block w-16 h-16 flex items-center justify-center rounded-full text-3xl">
                            😐
                        </label>
                    </div>
                    <div>
                        <input type="radio" id="mood_senang" name="suasana_hati" value="senang">
                        <label for="mood_senang" class="emoji-label neu-flat cursor-pointer inline-block w-16 h-16 flex items-center justify-center rounded-full text-3xl">
                            😊
                        </label>
                    </div>
                </div>
            </div>

            <!-- Teks Jurnal Neumorphic -->
            <div class="flex-1 flex flex-col mb-4">
                <textarea name="teks_jurnal" class="neu-pressed w-full flex-1 p-6 rounded-3xl focus:outline-none text-gray-700 resize-none" placeholder="Tulis catatan harianmu di sini..." required></textarea>
                <p class="text-xs text-gray-400 mt-4 text-center font-semibold">🔒 Catatanmu dienkripsi dan aman dari pandangan guru BK.</p>
            </div>

            <button type="submit" class="neu-btn-orange w-full text-white font-bold py-4 px-4 rounded-2xl transition duration-300">
                Simpan Jurnal Rahasia
            </button>
        </form>
    </div>

</body>
</html>