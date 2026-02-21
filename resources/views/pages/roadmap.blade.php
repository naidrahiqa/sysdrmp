@extends('layouts.app')

@section('title', 'SysAdmin & Network Engineer Roadmap')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 w-full">
    <div class="text-center mb-16">
        <h1 class="text-4xl sm:text-5xl font-black text-textBright tracking-tight mb-4 font-mono">
            > <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent">skill_tree.exe</span>
        </h1>
        <p class="max-w-2xl mx-auto text-lg text-textNormal font-medium">
            Jalur pembelajaran terstruktur untuk menjadi Systems Administrator & Network Engineer handal.
        </p>
    </div>

    <div class="space-y-12">
        <!-- Level 1 -->
        <div class="bg-bgCard border border-borderSoft rounded-xl p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
            <h2 class="text-2xl font-bold text-primary mb-2 font-mono">LEVEL_1: THE_NOOB (Dasar)</h2>
            <p class="text-textDim mb-6">Membangun pondasi jaringan dan OS Linux.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-accent animate-pulse shadow-[0_0_8px_#00e5ff]"></span>
                    <span class="text-textBright font-bold">Linux CLI Dasar</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-accent animate-pulse shadow-[0_0_8px_#00e5ff]"></span>
                    <span class="text-textBright font-bold">Networking TCP/IP</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                    <span class="text-textNormal">Mikrotik Basic Setup</span>
                </div>
            </div>
        </div>

        <!-- Level 2 -->
        <div class="bg-bgCard border border-borderSoft rounded-xl p-8 relative overflow-hidden">
            <h2 class="text-2xl font-bold text-accent mb-2 font-mono">LEVEL_2: JUNIOR_ADMIN</h2>
            <p class="text-textDim mb-6">Menyediakan layanan esensial di perusahaan.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                    <span class="text-textNormal">DNS (Bind9) & Web (Apache/Nginx)</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                    <span class="text-textNormal">Windows Server AD DS & GPO</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3">
                    <span class="w-3 h-3 rounded-full bg-warning"></span>
                    <span class="text-textNormal">VLAN & Routing (Mikrotik/Cisco)</span>
                </div>
            </div>
        </div>

        <!-- Level 3 -->
        <div class="bg-bgCard border border-borderSoft rounded-xl p-8 relative overflow-hidden">
            <h2 class="text-2xl font-bold text-warning mb-2 font-mono">LEVEL_3: SYSTEM_ARCHITECT (Dewa)</h2>
            <p class="text-textDim mb-6">Skalabilitas tingkat tinggi, otomatisasi, dan cloud.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                 <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3 opacity-70">
                    <span class="text-textDim">🔒</span>
                    <span class="text-textDim line-through hover:no-underline transition-all">Docker & Kubernetes</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3 opacity-70">
                    <span class="text-textDim">🔒</span>
                    <span class="text-textDim line-through hover:no-underline transition-all">Ansible & CI/CD Pipeline</span>
                </div>
                <div class="bg-bgDeep px-4 py-3 rounded border border-borderSoft flex items-center space-x-3 opacity-70">
                    <span class="text-textDim">🔒</span>
                    <span class="text-textDim line-through hover:no-underline transition-all">Proxmox / KVM Virtualization</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
