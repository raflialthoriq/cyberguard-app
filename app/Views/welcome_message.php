<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberGuard</title>
    <link rel="icon" type="image/png" href="logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            background-color: #f8fafc;
            scroll-behavior: smooth;
        }

        .bg-pattern {
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 24px 24px;
        }

        .neu-float {
            box-shadow: 10px 10px 20px #d1d5db, -10px -10px 20px #ffffff;
            background: #f8fafc;
        }
    </style>
</head>

<body class="font-sans text-gray-800 bg-pattern">

    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2 cursor-pointer" onclick="window.scrollTo(0,0)">
                    <span class="text-3xl"> <img src="logo.png" alt="Logo CyberGuard" class="h-10 w-10"></span>
                    <span class="font-black text-xl tracking-tight text-gray-900"><span class="text-blue-600">Cyber
                            Guard</span></span>
                </div>

                <div class="flex items-center space-x-3">
                    <?php if (session()->get('logged_in')): ?>
                        <?php
                        $link_dasbor = '/siswa/beranda';
                        if (session()->get('peran') == 'guru') $link_dasbor = '/guru/beranda';
                        if (session()->get('peran') == 'admin') $link_dasbor = '/admin/beranda';
                        ?>
                        <a href="<?= $link_dasbor ?>"
                            class="text-sm font-extrabold text-blue-600 bg-blue-50 px-5 py-2 rounded-full hover:bg-blue-100 transition border border-blue-200">
                            Ke Dasbor</a>
                    <?php else: ?>
                        <a href="/auth"
                            class="text-sm font-bold text-gray-600 hover:text-blue-600 transition hidden sm:block">Masuk</a>
                        <a href="/auth/register"
                            class="text-sm font-extrabold text-white bg-blue-600 px-5 py-2 rounded-full hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-0.5">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div
                class="inline-block mb-4 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 font-bold text-xs tracking-wide">
                Platform Edukasi & Intervensi Dini
            </div>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-gray-900 mb-6 leading-tight">
                Lindungi Kesehatan Mental di <br class="hidden lg:block" /> <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Era
                    Digital</span>
            </h1>
            <p class="mt-4 text-base md:text-lg text-gray-500 max-w-2xl mx-auto font-medium mb-10">
                Aplikasi berbasis mobile yang dirancang sebagai media pembelajaran interaktif untuk meningkatkan literasi digital dan kesadaran keamanan siber bagi siswa SMA/SMK/MA. 
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/auth/register"
                    class="bg-gray-900 text-white font-bold text-sm px-8 py-4 rounded-2xl hover:bg-gray-800 shadow-xl transition transform hover:-translate-y-1">Mulai
                    Perjalananmu</a>
                <a href="#fitur"
                    class="bg-white text-gray-700 border-2 border-gray-200 font-bold text-sm px-8 py-4 rounded-2xl hover:border-gray-300 hover:bg-gray-50 transition">Pelajari
                    Lebih Lanjut</a>
            </div>
        </div>
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-20 right-10 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-1/2 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-black text-gray-900">Kenapa Memilih CyberGuard?</h2>
                <p class="text-sm text-gray-500 font-bold mt-2">Fasilitas terpadu untuk siswa, guru, dan pengelola
                    sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="neu-float p-8 rounded-[30px] text-center border border-white">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6"> <i
                            data-lucide="book-open" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-800 mb-3">Modul Psikoedukasi</h3>
                    <p class="text-xs font-bold text-gray-500 leading-relaxed">Materi pembelajaran interaktif untuk
                        meningkatkan pemahaman siswa mengenai empati dan bahaya intimidasi siber.</p>
                </div>
                <div class="neu-float p-8 rounded-[30px] text-center border border-white">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6"><i
                            data-lucide="brain" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-800 mb-3">Simulasi CBT Visual</h3>
                    <p class="text-xs font-bold text-gray-500 leading-relaxed">Skenario permainan visual berbasis Terapi
                        Perilaku Kognitif untuk melatih respons mental saat menghadapi perundungan.</p>
                </div>
                <div class="neu-float p-8 rounded-[30px] text-center border border-white">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i data-lucide="shield-alert" class="w-8 h-8 text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-800 mb-3">Intervensi Dini BK</h3>
                    <p class="text-xs font-bold text-gray-500 leading-relaxed">Sistem deteksi otomatis yang membantu
                        Guru BK menjadwalkan konseling bagi siswa dengan skor kesejahteraan kritis.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="pengembang" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-14">
                <h2 class="text-3xl font-black text-gray-900">Profil Tim Pengembang</h2>
                <p class="text-sm text-gray-500 font-bold mt-2">
                    Kementerian Pendidikan Tinggi, Sains, dan Teknologi Republik Indonesia 
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Developer 1 -->
                <div class="neu-float rounded-[30px] p-8 text-center border border-white">
                    <img src="yara.png"
                        alt="Developer 1"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-white shadow-lg">

                    <h3 class="mt-6 text-lg font-black text-gray-800">
                        Yara Andita Anastasya, S.Psi., M.Psi., Psikolog.
                    </h3>

                    <p class="text-gray-600 text-xs font-extrabold uppercase tracking-wider mt-1">
                        Tim Periset
                    </p>

                    <p class="text-gray-500 text-sm mt-3">
                        Fakultas Kedokteran, Universitas Malikussaleh
                    </p>
                </div>

                <!-- Developer 2 -->
                <div class="neu-float rounded-[30px] p-8 text-center border border-white">
                    <img src="iqbal.png"
                        alt="Developer 2"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-white shadow-lg">

                    <h3 class="mt-6 text-lg font-black text-gray-800">
                        Muhammad Iqbal, M.Pd.
                    </h3>

                    <p class="text-gray-600 text-xs font-extrabold uppercase tracking-wider mt-1">
                        Tim Periset
                    </p>

                    <p class="text-gray-500 text-sm mt-3">
                        Fakultas Keguruan dan Ilmu Pendidikan, Universitas Malikussaleh
                    </p>
                </div>

                <!-- Developer 3 -->
                <div class="neu-float rounded-[30px] p-8 text-center border border-white">
                    <img src="ririn.png"
                        alt="Developer 3"
                        class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-white shadow-lg">

                    <h3 class="mt-6 text-lg font-black text-gray-800">
                        Ririn Rahayu, M.Pd.
                    </h3>

                    <p class="text-gray-600 text-xs font-extrabold uppercase tracking-wider mt-1">
                        Tim Periset
                    </p>

                    <p class="text-gray-500 text-sm mt-3">
                        Fakultas Keguruan dan Ilmu Pendidikan, Universitas Malikussaleh
                    </p>
                </div>

            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-gray-900 py-12 border-t border-gray-800">
        <div
            class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <div class="flex items-center gap-2 justify-center md:justify-start mb-2">
                    <span class="text-2xl grayscale"><img src="logo.png" alt="Logo CyberGuard" class="h-10 w-10"></span>
                    <span class="font-black text-lg text-white">Cyber<span class="text-blue-500">Guard</span></span>
                </div>
                <p class="text-xs font-bold text-gray-500">Hak Cipta &copy; <?= date('Y') ?> Tim Peneliti Universitas Malikussaleh.
                    Digital.</p>
            </div>

            <div class="text-xs font-bold text-gray-400 space-y-1">
                <div class="flex items-center gap-2">
                    <i data-lucide="map-pin-search" class="w-4 h-4 text-red-500"></i>
                    <span>Universitas Malikussaleh</span>
                </div>
            </div>
        </div>
    </footer>


    <script>
        lucide.createIcons();
    </script>
</body>

</html>