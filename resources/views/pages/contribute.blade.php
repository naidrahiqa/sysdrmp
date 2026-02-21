@extends('layouts.app')

@section('title', 'Contribute - SysAdmin Docs')

@section('content')
<div class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28 w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="mb-12 border-b border-borderSoft pb-8">
        <h1 class="text-4xl lg:text-5xl font-black text-textBright tracking-tight mb-4 font-mono">
           <span class="text-primary">>_</span> contribute
        </h1>
        <p class="text-lg text-textNormal leading-relaxed">
            Menemukan *Typo*? Ada konfigurasi Server yang sudah kadaluarsa? Atau Anda ingin berbagi ilmu Setup Docker Swarm kelas Enterprise? Mari berkontribusi membangun Pusat Data SysAdmin & Infrastruktur terbesar berbahasa Indonesia!
        </p>
    </div>

    <!-- How to contribute -->
    <div class="space-y-12">
        
        <!-- Step 1 -->
        <section class="bg-bgCard border border-borderSoft p-8 rounded-xl relative overflow-hidden group hover:border-accent transition-all duration-300">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-accent/10 rounded-full blur-[40px] group-hover:bg-accent/20 transition-all"></div>
            <h2 class="text-2xl font-bold text-textBright font-mono mb-4 flex items-center">
                <span class="w-8 h-8 rounded bg-bgDeep text-accent flex items-center justify-center mr-3 border border-borderStrong">1</span> 
                Format Penulisan (Seeder)
            </h2>
            <p class="text-textNormal mb-4">
                Saat ini, platform belum menyediakan fitur *WYSIWYG* di halaman web untuk menulis artikel demi menjaga kemurnian sistem Git/Version Control. Semua kontribusi artikel di-inject (Seed) via Database Seeder di platform Laravel.
            </p>
            <div class="bg-bgDeep rounded-md p-4 border border-borderStrong">
                <p class="text-sm font-mono text-textDim mb-2">// Anda bisa buka folder project : database/seeders/</p>
                <ul class="list-none space-y-2 text-sm text-textNormal font-mono">
                    <li>- <span class="text-primary">AdvancedSeeder.php</span> // Materi Sedang</li>
                    <li>- <span class="text-accent">ExpertSeeder.php</span> // Materi Skala Datacenter</li>
                    <li>- <span class="text-warning">SecuritySeeder.php</span> // Materi Jaringan/Hack</li>
                </ul>
            </div>
        </section>

        <!-- Step 2 -->
        <section class="bg-bgCard border border-borderSoft p-8 rounded-xl relative overflow-hidden group hover:border-primary transition-all duration-300">
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-primary/10 rounded-full blur-[40px] group-hover:bg-primary/20 transition-all"></div>
            <h2 class="text-2xl font-bold text-textBright font-mono mb-6 flex items-center">
                <span class="w-8 h-8 rounded bg-bgDeep text-primary flex items-center justify-center mr-3 border border-borderStrong">2</span> 
                Struktur Array Artikel (Template)
            </h2>
            <div class="prose prose-invert max-w-none">
                <p class="text-textNormal mb-4">Bila Anda ingin menyumbang modul baru, silakan *Copy-Paste* struktur array berikut dan edit menggunakan bahasa HTML ringan.</p>
                <div class="relative overflow-x-auto rounded-lg border border-borderSoft">
<pre class="!m-0 !rounded-none !bg-[#090a0f] text-sm"><code class="language-php">[   
    'title' => 'Judul Artikel Anda',
    'slug' => Str::slug('Judul Artikel Anda'),
    'category' => 'Debian Server', // Atau Windows Server, Networking, Cloud, Security
    'author' => 'Nama Samaran Anda',
    'read_time' => 5, // Berapa menit orang membacanya
    'excerpt' => 'Deskripsi kalimat singkat yang menjadi daya tarik materi ini.',
    'content' => "&lt;h3&gt;1. Pembukaan Konsep&lt;/h3&gt;
&lt;p&gt;Jelaskan kenapa konfigurasi ini dibutuhkan.&lt;/p&gt;
&lt;pre&gt;&lt;code class=\"language-bash\"&gt;# Komentar instalasi Anda
apt install paket-baru -y&lt;/code&gt;&lt;/pre&gt;",
]</code></pre>
                </div>
            </div>
        </section>

        <!-- Step 3 -->
        <section class="bg-bgCard border border-borderSoft p-8 rounded-xl relative overflow-hidden group hover:border-warning transition-all duration-300">
            <h2 class="text-2xl font-bold text-textBright font-mono mb-4 flex items-center">
                <span class="w-8 h-8 rounded bg-bgDeep text-warning flex items-center justify-center mr-3 border border-borderStrong">3</span> 
                Push Request di GitHub
            </h2>
            <p class="text-textNormal mb-6">
                Setelah Anda mengembangkan materi secukupnya lewat IDE Anda (VS Code/PHPStorm), lakukan Pull Request ke repositori pusat. Author Inti (System Administrator) akan mereview kode PHP-nya agar situs terhindar dari XSS Injections sebelum di-_merge_ menjadi Modul Resmi Web Terbuka.
            </p>

            <a href="https://github.com" target="_blank" class="inline-flex flex-col items-center justify-center bg-bgDeep border border-borderStrong hover:border-textBright transition-colors text-textBright font-bold py-6 px-12 rounded-xl text-center group/btn shadow-[0_10px_20px_rgba(0,0,0,0.3)]">
                <svg viewBox="0 0 24 24" class="w-12 h-12 mb-3 fill-current group-hover/btn:scale-110 transition-transform"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path></svg>
                <span>Pergi Ke Repositori GitHub Utama</span>
                <span class="text-xs text-textDim mt-2 font-mono font-normal">github.com/SysAdminRoadmap/Docs</span>
            </a>
        </section>

    </div>
</div>
@endsection
