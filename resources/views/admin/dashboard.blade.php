@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', '~/admin/dashboard')

@section('content')
{{-- ── Stats ──────────────────────────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $statCards = [
            ['label'=>'Total Articles','value'=>$stats['total'],        'color'=>'text-accent',   'glow'=>'shadow-[0_0_15px_rgba(0,229,255,0.15)]',  'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label'=>'Beginner',       'value'=>$stats['beginner'],    'color'=>'text-success',  'glow'=>'shadow-[0_0_15px_rgba(158,206,106,0.15)]', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Intermediate',   'value'=>$stats['intermediate'],'color'=>'text-warning',  'glow'=>'shadow-[0_0_15px_rgba(255,184,108,0.15)]', 'icon'=>'M13 10V3L4 14h7v7l9-11h-7z'],
            ['label'=>'Advanced',       'value'=>$stats['advanced'],    'color'=>'text-orange-500','glow'=>'shadow-[0_0_15px_rgba(249,115,22,0.15)]', 'icon'=>'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
            ['label'=>'Expert',         'value'=>$stats['expert'],      'color'=>'text-primary',  'glow'=>'shadow-[0_0_15px_rgba(255,0,127,0.15)]',  'icon'=>'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
        ];
    @endphp
    @foreach($statCards as $s)
    <div class="bg-bgCard border border-borderSoft rounded-xl p-5 {{ $s['glow'] }} hover:border-borderStrong transition-all">
        <div class="flex items-start justify-between mb-3">
            <p class="text-[10px] font-bold font-mono uppercase tracking-widest text-textDim">{{ $s['label'] }}</p>
            <svg class="w-4 h-4 {{ $s['color'] }} opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/></svg>
        </div>
        <p class="text-3xl font-black {{ $s['color'] }} font-mono">{{ $s['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- ── Recent Articles ─────────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 bg-bgCard border border-borderSoft rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-borderSoft flex items-center justify-between">
            <h2 class="text-sm font-bold font-mono text-textBright">Recent Articles</h2>
            <a href="{{ route('admin.articles.create') }}" class="text-[10px] font-mono font-bold text-primary border border-primary/40 hover:border-primary px-3 py-1.5 rounded transition-all">+ NEW</a>
        </div>
        <div class="divide-y divide-borderSoft">
            @forelse($recentArticles as $a)
            <div class="px-6 py-3.5 flex items-center justify-between group hover:bg-bgElevated/40 transition-all">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-1.5 h-1.5 rounded-full shrink-0
                        {{ $a->level_id == 1 ? 'bg-success' : ($a->level_id == 2 ? 'bg-warning' : ($a->level_id == 3 ? 'bg-orange-500' : 'bg-primary shadow-[0_0_6px_rgba(255,0,127,0.8)]')) }}">
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm text-textNormal truncate font-medium">{{ $a->title }}</p>
                        <p class="text-[10px] font-mono text-textDim">{{ $a->category }} · {{ $a->read_time }}min</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0 ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.articles.edit', $a) }}" class="text-[10px] font-mono text-accent hover:text-white border border-accent/30 hover:border-accent px-2.5 py-1 rounded transition-all">EDIT</a>
                    <a href="{{ route('tutorials.show', $a->slug) }}" target="_blank" class="text-[10px] font-mono text-textDim hover:text-textBright border border-borderStrong hover:border-textDim px-2.5 py-1 rounded transition-all">VIEW</a>
                </div>
            </div>
            @empty
            <p class="px-6 py-8 text-center text-textDim font-mono text-sm">No articles yet.</p>
            @endforelse
        </div>
        <div class="px-6 py-3 border-t border-borderSoft">
            <a href="{{ route('admin.articles') }}" class="text-xs font-mono text-textDim hover:text-accent transition-colors">View all articles →</a>
        </div>
    </div>

    {{-- ── CLI Quick Info + Categories ─────────────────────────────────────── --}}
    <div class="space-y-6">
        {{-- CLI Terminal Box --}}
        <div class="cli-box p-5">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                <div class="w-3 h-3 rounded-full bg-success/80"></div>
                <span class="text-textDim text-[10px] font-mono ml-2">admin@sysrdmp ~ $</span>
            </div>
            <div class="space-y-1.5 text-sm font-mono">
                <p class="cli-line text-textNormal">db:status</p>
                <p class="text-success pl-4">✓ SQLite connected</p>
                <p class="cli-line text-textNormal mt-2">article:count</p>
                <p class="text-accent pl-4">{{ $stats['total'] }} records found</p>
                <p class="cli-line text-textNormal mt-2">category:list</p>
                @foreach($categories as $cat)
                <p class="pl-4 text-textDim">→ <span class="text-warning">{{ $cat }}</span></p>
                @endforeach
                <p class="cli-line text-textNormal mt-2">server:info</p>
                <p class="text-accent pl-4">Laravel {{ app()->version() }}</p>
                <p class="pl-4 text-textDim">PHP {{ PHP_VERSION }}</p>
                <p class="mt-3 text-textDim animate-pulse">█</p>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="bg-bgCard border border-borderSoft rounded-xl p-5">
            <p class="text-xs font-bold font-mono uppercase tracking-widest text-textDim mb-4">Quick Actions</p>
            <div class="space-y-2">
                <a href="{{ route('admin.articles.create') }}" class="flex items-center gap-3 w-full px-4 py-3 bg-primary/10 border border-primary/30 hover:border-primary text-primary font-bold font-mono text-sm rounded-lg transition-all hover:shadow-[0_0_12px_rgba(255,0,127,0.2)]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Article
                </a>
                <a href="{{ route('admin.articles') }}" class="flex items-center gap-3 w-full px-4 py-3 bg-bgElevated border border-borderStrong hover:border-accent text-textNormal hover:text-accent font-bold font-mono text-sm rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h7"/></svg>
                    Manage Articles
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 w-full px-4 py-3 bg-bgElevated border border-borderStrong hover:border-textDim text-textDim hover:text-textNormal font-bold font-mono text-sm rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Public Site
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
