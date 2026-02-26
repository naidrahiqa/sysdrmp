<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SYSRDMP Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-twilight.min.css" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        bgDeep:      '#0f111a',
                        bgCard:      '#1e2130',
                        bgElevated:  '#2a2e42',
                        borderSoft:  '#2a2e42',
                        borderStrong:'#444b6a',
                        textBright:  '#ffffff',
                        textNormal:  '#a9b1d6',
                        textDim:     '#787c99',
                        primary:     '#ff007f',
                        primaryHover:'#ff4d94',
                        accent:      '#00e5ff',
                        warning:     '#ffb86c',
                        success:     '#9ece6a',
                    },
                    fontFamily: {
                        sans: ['Inter','sans-serif'],
                        mono: ['JetBrains Mono','monospace'],
                    },
                    typography: (theme) => ({
                        DEFAULT: {
                            css: {
                                color: theme('colors.textNormal'),
                                'h1,h2,h3,h4': { color: theme('colors.textBright'), fontWeight:'800' },
                                a: { color: theme('colors.accent') },
                                strong: { color: theme('colors.textBright') },
                                code: { color: theme('colors.primary'), backgroundColor:'rgba(255,0,127,0.1)', padding:'0.2rem 0.4rem', borderRadius:'0.25rem', fontWeight:'600' },
                                'code::before': { content:'""' },
                                'code::after':  { content:'""' },
                                pre: { backgroundColor:'#090a0f', border:`1px solid ${theme('colors.borderStrong')}`, borderRadius:'0.5rem' },
                                'pre code': { backgroundColor:'transparent', color:'#a9b1d6', padding:'0', fontWeight:'400' },
                                blockquote: { borderLeftColor: theme('colors.primary'), color: theme('colors.textDim'), backgroundColor: theme('colors.bgCard'), padding:'0.5rem 1rem', borderRadius:'0 0.25rem 0.25rem 0', fontStyle:'normal' },
                            },
                        },
                    }),
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f111a; }
        ::-webkit-scrollbar-thumb { background: #2a2e42; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444b6a; }

        pre[class*="language-"] { background: #090a0f !important; margin: 1.5em 0; border: 1px solid #2a2e42; }

        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-bold font-mono text-textDim transition-all hover:text-textBright hover:bg-bgElevated; }
        .sidebar-link.active { @apply text-primary bg-bgElevated border border-borderStrong shadow-[0_0_12px_rgba(255,0,127,0.15)]; }

        /* CLI box */
        .cli-box { background: #090a0f; border: 1px solid #2a2e42; border-radius: 0.5rem; font-family: 'JetBrains Mono', monospace; }
        .cli-line::before { content: '$ '; color: #9ece6a; }

        /* Textarea & input shared */
        .admin-input { @apply w-full bg-bgDeep border border-borderStrong text-textNormal rounded-lg px-4 py-3 font-mono text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all placeholder:text-textDim; }
        .admin-label { @apply block text-xs font-bold font-mono uppercase tracking-widest text-textDim mb-2; }
    </style>
</head>
<body class="bg-bgDeep text-textNormal antialiased flex h-screen overflow-hidden">

    {{-- ── Sidebar ─────────────────────────────────────────────────── --}}
    <aside id="admin-sidebar" class="w-64 min-h-screen bg-bgCard border-r border-borderSoft flex flex-col shrink-0 z-40">
        {{-- Brand --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-borderSoft shrink-0">
            <div class="w-8 h-8 bg-transparent border-2 border-primary rounded flex items-center justify-center font-mono font-bold text-primary shadow-[0_0_10px_rgba(255,0,127,0.5)]">_</div>
            <div>
                <p class="text-textBright font-black font-mono leading-none">sysrdmp</p>
                <p class="text-primary text-[10px] font-mono tracking-widest uppercase">admin panel</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            <p class="text-[10px] uppercase tracking-widest text-textDim font-bold px-4 mb-3">Main</p>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>

            <p class="text-[10px] uppercase tracking-widest text-textDim font-bold px-4 mt-5 mb-3">Content</p>
            <a href="{{ route('admin.articles') }}"
               class="sidebar-link {{ request()->routeIs('admin.articles') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Articles
            </a>
            <a href="{{ route('admin.articles.create') }}"
               class="sidebar-link {{ request()->routeIs('admin.articles.create') || request()->routeIs('admin.articles.edit') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Article
            </a>

            <p class="text-[10px] uppercase tracking-widest text-textDim font-bold px-4 mt-5 mb-3">Site</p>
            <a href="{{ route('home') }}" target="_blank"
               class="sidebar-link">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Site
            </a>
        </nav>

        {{-- Footer / Logout --}}
        <div class="px-4 py-4 border-t border-borderSoft shrink-0 space-y-2">
            @if(session('admin_logged_in_at'))
            <p class="text-[10px] font-mono text-textDim px-1">
                Session since<br>
                <span class="text-textNormal">{{ \Carbon\Carbon::parse(session('admin_logged_in_at'))->format('H:i · d M') }}</span>
            </p>
            @endif
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-bold font-mono text-textDim hover:text-primary hover:bg-primary/10 border border-transparent hover:border-primary/30 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
            <p class="text-[9px] font-mono text-textDim px-1">SYSRDMP Admin v1.0</p>
        </div>
    </aside>

    {{-- ── Main Area ───────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top bar --}}
        <header class="h-16 border-b border-borderSoft bg-bgCard flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center gap-3">
                <span class="text-textDim font-mono text-xs">&gt;_</span>
                <h1 class="text-textBright font-bold font-mono text-sm">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                {{-- Flash success --}}
                @if(session('success'))
                <div id="flash-msg" class="flex items-center gap-2 bg-success/10 border border-success/40 text-success text-xs font-mono px-4 py-2 rounded-lg">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
                <script>setTimeout(() => { const el = document.getElementById('flash-msg'); if(el) el.style.opacity = '0'; }, 4000);</script>
                @endif
                <span class="text-[10px] font-mono text-textDim bg-bgElevated px-3 py-1.5 rounded border border-borderStrong">{{ now()->format('Y-m-d H:i') }}</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6 bg-bgDeep">
            @yield('content')
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    @yield('scripts')
</body>
</html>
