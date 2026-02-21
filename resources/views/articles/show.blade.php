@extends('layouts.app')

@section('title', $article->title . ' - SysAdminDocs')

@section('content')
<!-- Header Banner / Backdrop -->
<div class="bg-bgCard border-b border-borderSoft pt-10 pb-16 w-full relative overflow-hidden">
    <div class="absolute inset-0 bg-[linear-gradient(45deg,transparent_25%,rgba(255,0,127,0.05)_50%,transparent_75%,transparent_100%)] bg-[length:250px_250px] animate-[gradient_3s_linear_infinite]"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Breadcrumb -->
        <nav class="flex text-xs text-textDim font-bold mb-8 font-mono tracking-widest uppercase" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">~/root</a></li>
                <li><span class="text-borderStrong">/</span></li>
                <li><a href="{{ route('tutorials.index', ['category' => $article->category]) }}" class="hover:text-accent transition-colors">{{ str_replace(' ', '_', strtolower($article->category)) }}</a></li>
                <li><span class="text-borderStrong">/</span></li>
                <li class="text-textNormal truncate max-w-[200px]">{{ $article->slug }}</li>
            </ol>
        </nav>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-textBright leading-[1.2] tracking-tight mb-6 mt-4">
            {{ $article->title }}
        </h1>
        
        <p class="text-lg text-textNormal mb-10 leading-relaxed max-w-3xl">
            {{ $article->excerpt }}
        </p>

        <div class="flex flex-wrap items-center gap-6 mt-6 bg-bgDeep/50 p-4 rounded-lg border border-borderSoft inline-flex">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded bg-primary text-white flex items-center justify-center font-black text-lg shadow-[0_0_10px_rgba(255,0,127,0.4)]">
                    {{ substr($article->author, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-textBright">{{ $article->author }}</p>
                    <p class="text-[10px] text-primary font-mono tracking-widest uppercase mt-0.5">Author</p>
                </div>
            </div>
            
            <div class="h-8 w-px bg-borderSoft hidden sm:block mx-2"></div>
            
            <div class="flex items-center gap-6">
                <div class="flex flex-col">
                    <span class="text-[10px] text-textDim uppercase font-bold tracking-widest mb-1 font-mono">Last Mod</span>
                    <span class="text-xs font-bold font-mono text-textNormal">
                        {{ $article->updated_at->format('Y-m-d') }}
                    </span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-textDim uppercase font-bold tracking-widest mb-1 font-mono">Time</span>
                    <span class="text-xs font-bold font-mono text-accent">
                        {{ $article->read_time }}min
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reading Container -->
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 w-full">
    <div class="prose prose-lg max-w-none text-textNormal">
        {!! $article->content !!}
    </div>

    <!-- Article Footer / Share -->
    <footer class="mt-20 pt-10 border-t border-borderSoft relative">
        <div class="bg-bgCard border border-borderSoft rounded-xl p-8 md:flex md:items-center md:justify-between shadow-[0_0_30px_rgba(0,0,0,0.5)] relative overflow-hidden group">
            <div class="absolute -inset-1 bg-gradient-to-r from-primary to-accent blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
            <div class="relative z-10 bg-bgCard inset-0.5 absolute rounded-[10px]"></div>
            
            <div class="relative z-20 mb-6 md:mb-0 max-w-xl p-2">
                <h3 class="text-2xl font-black text-textBright mb-2 font-mono">System.Share()</h3>
                <p class="text-textNormal text-sm">Bagikan resource teknis ini ke session lain untuk meningkatkan efisiensi.</p>
            </div>
            <div class="relative z-20 flex space-x-4 shrink-0 p-2">
                <button class="px-5 py-3 bg-bgDeep text-textBright border border-borderSoft font-bold font-mono text-sm rounded hover:border-primary hover:text-primary transition-all flex items-center justify-center">
                    Share / Twitter
                </button>
                <button class="px-5 py-3 bg-primary text-white font-bold font-mono text-sm rounded shadow-[0_0_15px_rgba(255,0,127,0.5)] border border-primary hover:bg-bgDeep hover:text-primary transition-colors flex items-center justify-center">
                    Copy URL
                </button>
            </div>
        </div>
    </footer>
</article>
@endsection
