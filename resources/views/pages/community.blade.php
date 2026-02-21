@extends('layouts.app')

@section('title', 'SysAdmin Community')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full text-center">
    <div class="mx-auto inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/20 text-primary mb-8 shadow-[0_0_30px_rgba(255,0,127,0.4)]">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    </div>
    
    <h1 class="text-4xl sm:text-5xl font-black text-textBright tracking-tight mb-6 font-mono">
        Join the <span class="text-accent">Network</span>
    </h1>
    
    <p class="text-xl text-textNormal mb-12 max-w-2xl mx-auto leading-relaxed">
        SysAdmin DOCS bukanlah dokumentasi mati. Kami adalah ruang tongkrongan para IT Support, Network Engineer, hingga DevOps untuk bertukar *bug*, script ngawur, dan keluhan soal *user*.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="#" class="group relative overflow-hidden bg-bgCard border border-borderSoft rounded-xl p-8 hover:border-[#5865F2] transition-colors text-left flex flex-col justify-between items-start h-48 cursor-pointer">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#5865F2]/10 rounded-full blur-3xl group-hover:bg-[#5865F2]/20 transition-all"></div>
            <div>
                <h3 class="text-2xl font-bold text-textBright mb-2 flex items-center">
                    <span class="text-[#5865F2] mr-3 font-mono">#</span> Discord Server
                </h3>
                <p class="text-textDim">Ngopi bareng, bahas homelab, tumpah keluh kesah server mati jam 3 pagi.</p>
            </div>
            <span class="text-[#5865F2] font-mono font-bold group-hover:underline">> Connect</span>
        </a>

        <a href="#" class="group relative overflow-hidden bg-bgCard border border-borderSoft rounded-xl p-8 hover:border-[#0088cc] transition-colors text-left flex flex-col justify-between items-start h-48 cursor-pointer">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#0088cc]/10 rounded-full blur-3xl group-hover:bg-[#0088cc]/20 transition-all"></div>
            <div>
                <h3 class="text-2xl font-bold text-textBright mb-2 flex items-center">
                    <span class="text-[#0088cc] mr-3 font-mono">@</span> Telegram Group
                </h3>
                <p class="text-textDim">Update kilat seputar CVE terbaru dan tanya jawab error Mikrotik secara real-time.</p>
            </div>
            <span class="text-[#0088cc] font-mono font-bold group-hover:underline">> Join Chat</span>
        </a>
    </div>
</div>
@endsection
