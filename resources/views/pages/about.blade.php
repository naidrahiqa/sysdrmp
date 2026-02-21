@extends('layouts.app')

@section('title', 'About SysAdmin Docs')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
    <div class="prose prose-invert prose-lg max-w-none">
        <h1 class="text-4xl sm:text-5xl font-black font-mono text-textBright mb-10 border-b border-borderSoft pb-6 inline-block">
            > whoami
        </h1>
        
        <p class="text-xl text-textNormal leading-relaxed font-medium">
            <strong class="text-accent font-bold">SysAdmin Docs</strong> lahir dari rasa frustrasi ketika membaca tumpukan dokumentasi PDF tebal yang kaku dan usang. 
        </p>

        <p class="text-textDim leading-relaxed">
            Platform ini memuat arsip-arsip konfigurasi krusial yang disimpan dari masa lalu, ditulis ulang dengan bahasa tongkrongan dan format yang mudah di copy-paste. Didedikasikan bagi anda yang sering terjebak dalam masalah <code class="bg-primary/20 text-primary px-2 py-0.5 rounded">nano config</code> pada jam 2 Pagi tanpa tahu <em>mengapa baris itu diketik</em>.
        </p>

        <h3 class="font-mono text-xl font-bold text-accent mt-12 mb-6 border-b border-borderSoft pb-2 inline-block">
            $ stack_used
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 font-mono text-sm">
            <div class="bg-bgCard p-4 rounded border border-borderSoft flex items-center">
                <span class="text-primary mr-3 font-bold">>_</span>
                <div>
                    <span class="block text-textDim text-xs uppercase tracking-widest mb-1">Frontend</span>
                    <span class="text-textBright font-bold">Blade + Tailwind CSS</span>
                </div>
            </div>
            <div class="bg-bgCard p-4 rounded border border-borderSoft flex items-center">
                <span class="text-primary mr-3 font-bold">>_</span>
                <div>
                    <span class="block text-textDim text-xs uppercase tracking-widest mb-1">Backend</span>
                    <span class="text-textBright font-bold">Laravel Framework</span>
                </div>
            </div>
            <div class="bg-bgCard p-4 rounded border border-borderSoft flex items-center">
                <span class="text-primary mr-3 font-bold">>_</span>
                <div>
                    <span class="block text-textDim text-xs uppercase tracking-widest mb-1">Database</span>
                    <span class="text-textBright font-bold">SQLite / MariaDB</span>
                </div>
            </div>
            <div class="bg-bgCard p-4 rounded border border-borderSoft flex items-center">
                <span class="text-primary mr-3 font-bold">>_</span>
                <div>
                    <span class="block text-textDim text-xs uppercase tracking-widest mb-1">Deployment</span>
                    <span class="text-textBright font-bold">Docker Container</span>
                </div>
            </div>
        </div>

        <div class="mt-16 p-6 md:p-8 bg-bgCard border-l-4 border-warning rounded-r-xl shadow-lg relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-warning/10 rounded-full blur-2xl"></div>
            <p class="mb-0 text-textBright italic font-mono relative z-10 text-lg">
                "We build the things that developers run their things on."
            </p>
        </div>
    </div>
</div>
@endsection
