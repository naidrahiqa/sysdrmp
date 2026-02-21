@extends('layouts.app')

@section('title', 'Pusat Literasi SysAdmin & Infrastruktur TI')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28 w-full">
    <!-- Neon grid background -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#2a2e42_1px,transparent_1px),linear-gradient(to_bottom,#2a2e42_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-30"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-lg h-64 bg-primary/20 blur-[100px] rounded-full pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-black text-textBright tracking-tight mb-6">
            Pusat Data <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent drop-shadow-[0_0_15px_rgba(255,0,127,0.5)]">SysAdmin</span>
        </h1>
        <p class="max-w-2xl mx-auto text-lg lg:text-xl text-textNormal mb-12 font-medium">
            Kumpulan panduan teknis, tutorial instalasi, dan dokumentasi arsitektur jaringan.
        </p>
        <div class="max-w-2xl mx-auto flex items-center bg-bgCard border border-borderSoft rounded-lg p-2 focus-within:ring-1 focus-within:ring-accent focus-within:border-accent shadow-[0_0_20px_rgba(0,0,0,0.5)] transition-all relative z-20">
            <svg class="h-6 w-6 text-accent ml-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <input type="text" placeholder=">> Cari command, modul iptables, ccna..." class="w-full bg-transparent border-none text-textBright focus:ring-0 px-4 py-3 placeholder-textDim font-mono text-sm outline-none" disabled />
            <span class="mr-2 px-3 py-1.5 text-xs font-bold font-mono bg-bgDeep text-accent rounded border border-borderSoft">Ctrl+K</span>
        </div>
    </div>
</div>

<!-- Layout Two Columns -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 w-full relative z-10">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filter -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="sticky top-28 p-1">
                <h3 class="font-bold font-mono text-textDim mb-4 flex items-center text-sm tracking-widest uppercase">
                    <span class="w-2 h-2 bg-primary mr-2 rounded-full shadow-[0_0_8px_rgba(255,0,127,0.8)]"></span>
                    Directory
                </h3>
                <ul class="space-y-1 text-sm font-bold font-mono">
                    <li>
                        <a href="{{ route('tutorials.index') }}" class="flex items-center px-4 py-3 rounded-md transition-all {{ !request('category') ? 'bg-primary/10 text-primary border-l-2 border-primary' : 'text-textNormal hover:text-textBright hover:bg-bgCard border-l-2 border-transparent hover:border-borderSoft' }}">
                            ~/all_modules
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('tutorials.index', ['category' => $cat]) }}" class="flex items-center px-4 py-3 rounded-md transition-all {{ request('category') == $cat ? 'bg-accent/10 text-accent border-l-2 border-accent' : 'text-textNormal hover:text-textBright hover:bg-bgCard border-l-2 border-transparent hover:border-borderSoft' }}">
                            /{{ str_replace(' ', '_', strtolower($cat)) }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Articles Feed -->
        <div class="flex-1 min-w-0">
            <div class="mb-8 flex items-end justify-between border-b border-borderSoft pb-4">
                <h2 class="text-3xl font-black text-textBright tracking-tight font-mono">
                    {{ request('category') ? '> ' . request('category') : '> latest_updates' }}
                </h2>
                <div class="px-3 py-1 bg-bgCard text-accent text-sm font-mono font-bold rounded border border-borderStrong shadow-sm animate-pulse">
                    [{{ $articles->total() }} results]
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($articles as $article)
                <article class="bg-bgCard border-l-4 {{ $article->category == 'Debian Server' ? 'border-l-primary' : ($article->category == 'Networking' ? 'border-l-accent' : 'border-l-warning') }} border-y border-r border-y-borderSoft border-r-borderSoft hover:border-r-borderStrong hover:bg-bgElevated rounded-r-xl p-6 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(0,0,0,0.5)] hover:-translate-y-1 group flex flex-col h-full cursor-pointer" onclick="window.location.href='{{ route('tutorials.show', $article->slug) }}'">
                    <div class="flex items-center justify-between text-xs mb-4 font-bold font-mono">
                        <span class="{{ $article->category == 'Debian Server' ? 'text-primary' : ($article->category == 'Networking' ? 'text-accent' : 'text-warning') }} bg-bgDeep px-2 py-1 rounded shadow-inner border border-bgDeep">
                            #{{ strtolower(str_replace(' ', '', $article->category)) }}
                        </span>
                        <span class="text-textDim flex items-center">
                            ~ {{ $article->read_time }}m read
                        </span>
                    </div>
                    
                    <a href="{{ route('tutorials.show', $article->slug) }}" class="block flex-1">
                        <h3 class="text-xl font-bold text-textBright mb-3 leading-snug group-hover:text-white transition-colors">{{ $article->title }}</h3>
                        <p class="text-textNormal text-sm line-clamp-3 leading-relaxed">{{ $article->excerpt }}</p>
                    </a>
                    
                    <div class="mt-6 pt-4 flex items-center justify-between border-t border-bgDeep/50">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-textDim uppercase tracking-widest font-mono">Level</span>
                            <span class="text-xs px-2 py-0.5 mt-1 border rounded bg-transparent {{ $article->level_color }} font-bold inline-block">{{ $article->level_name }}</span>
                        </div>
                        <span class="text-[10px] text-textDim uppercase tracking-wider font-mono">{{ $article->author }}</span>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-24 text-center border border-borderSoft border-dashed rounded-xl bg-bgCard">
                    <h3 class="text-2xl font-black text-textBright mb-2 font-mono text-primary">ERR_404_NOT_FOUND</h3>
                    <p class="text-textNormal font-mono">Data cluster belum memiliki modul ini.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 flex justify-center" id="pagination-container">
                {{ $articles->links() }}
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const feedContainer = document.querySelector('.flex-1.min-w-0');
        if (!feedContainer) return;

        feedContainer.addEventListener('click', function(e) {
            const link = e.target.closest('#pagination-container nav a');
            if (!link || !link.href) return;

            e.preventDefault();

            // Add loading state
            feedContainer.style.opacity = '0.5';
            feedContainer.style.pointerEvents = 'none';
            feedContainer.style.transition = 'opacity 0.2s';

            fetch(link.href, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newFeedContainer = doc.querySelector('.flex-1.min-w-0');
                
                if (newFeedContainer) {
                    feedContainer.innerHTML = newFeedContainer.innerHTML;
                    history.pushState(null, '', link.href);
                }
            })
            .catch(error => {
                console.error('Error fetching page:', error);
                window.location.href = link.href; // Fallback
            })
            .finally(() => {
                feedContainer.style.opacity = '1';
                feedContainer.style.pointerEvents = 'auto';
            });
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            window.location.reload();
        });
    });
</script>
@endsection
