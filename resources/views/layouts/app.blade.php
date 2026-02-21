<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SysAdmin Tutorial Docs')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- PrismJS Theme (Night Owl style) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-twilight.min.css" rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        bgDeep: '#0f111a', /* Very dark blue/black */
                        bgCard: '#1e2130', /* Slightly lighter dark */
                        bgElevated: '#2a2e42', /* Elevated elements */
                        borderSoft: '#2a2e42', /* Subtle borders */
                        borderStrong: '#444b6a', /* Visible borders */
                        textBright: '#ffffff', /* Pure white for headings */
                        textNormal: '#a9b1d6', /* Soft blue-gray for body */
                        textDim: '#787c99', /* Muted text */
                        primary: '#ff007f', /* Cyberpunk Pink/Magenta */
                        primaryHover: '#ff4d94', /* Lighter Pink */
                        accent: '#00e5ff', /* Cyan */
                        warning: '#ffb86c', /* Orange */
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    typography: (theme) => ({
                        DEFAULT: {
                            css: {
                                color: theme('colors.textNormal'),
                                'h1, h2, h3, h4, h5, h6': {
                                    color: theme('colors.textBright'),
                                    fontWeight: '800',
                                },
                                a: {
                                    color: theme('colors.accent'),
                                    textDecoration: 'none',
                                    fontWeight: '600',
                                    '&:hover': {
                                        color: theme('colors.textBright'),
                                        textDecoration: 'underline',
                                    },
                                },
                                strong: {
                                    color: theme('colors.textBright'),
                                },
                                code: {
                                    color: theme('colors.primary'),
                                    backgroundColor: 'rgba(255, 0, 127, 0.1)',
                                    padding: '0.2rem 0.4rem',
                                    borderRadius: '0.25rem',
                                    fontWeight: '600',
                                },
                                'code::before': { content: '""' },
                                'code::after': { content: '""' },
                                pre: {
                                    backgroundColor: '#090a0f',
                                    border: `1px solid ${theme('colors.borderStrong')}`,
                                    borderRadius: '0.5rem',
                                    padding: '1.2rem',
                                },
                                'pre code': {
                                    backgroundColor: 'transparent',
                                    color: '#a9b1d6',
                                    padding: '0',
                                    fontWeight: '400',
                                },
                                blockquote: {
                                    borderLeftColor: theme('colors.primary'),
                                    color: theme('colors.textDim'),
                                    backgroundColor: theme('colors.bgCard'),
                                    padding: '0.5rem 1rem',
                                    borderRadius: '0 0.25rem 0.25rem 0',
                                    fontStyle: 'normal'
                                }
                            },
                        },
                    }),
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f111a; }
        ::-webkit-scrollbar-thumb { background: #2a2e42; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #444b6a; }
        
        .prose h3 { margin-top: 2.5em; margin-bottom: 0.8em; border-bottom: 1px solid #2a2e42; padding-bottom: 0.5em; color: #00e5ff !important; }
        pre[class*="language-"] { background: #090a0f !important; margin: 1.5em 0; border: 1px solid #2a2e42; box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.5); }
    </style>
</head>
<body class="bg-bgDeep text-textNormal antialiased selection:bg-primary selection:text-white flex flex-col min-h-screen">

    <!-- Top Navigation -->
    <header class="sticky top-0 z-50 w-full border-b border-borderSoft bg-bgDeep/80 backdrop-blur-xl shadow-lg">
        <div class="max-w-7xl mx-auto flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 font-black text-xl text-textBright group">
                    <div class="w-8 h-8 bg-transparent border-2 border-primary rounded flex items-center justify-center font-mono font-bold text-primary shadow-[0_0_10px_rgba(255,0,127,0.5)] group-hover:bg-primary group-hover:text-white group-hover:shadow-[0_0_15px_rgba(255,0,127,0.8)] transition-all">
                        _
                    </div>
                    <span>sysrdmp<span class="text-primary">.docs</span></span>
                </a>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-sm font-bold text-textDim">
                <a href="{{ route('home') }}" class="hover:text-accent transition-colors {{ request()->routeIs('home') || request()->routeIs('tutorials.*') ? 'text-textBright' : '' }}">LIBRARY</a>
                <a href="{{ route('roadmap') }}" class="hover:text-accent transition-colors {{ request()->routeIs('roadmap') ? 'text-textBright' : '' }}">ROADMAP</a>
                <a href="{{ route('community') }}" class="hover:text-accent transition-colors {{ request()->routeIs('community') ? 'text-textBright' : '' }}">COMMUNITY</a>
                <a href="{{ route('about') }}" class="hover:text-accent transition-colors {{ request()->routeIs('about') ? 'text-textBright' : '' }}">ABOUT</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="{{ route('contribute') }}" class="text-sm font-bold bg-primary text-white border border-primary px-5 py-2 rounded shadow-[0_0_10px_rgba(255,0,127,0.3)] hover:bg-bgDeep hover:text-primary transition-all">
                    / contribute
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 w-full bg-bgDeep" id="main-content" wire:navigate>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-borderSoft bg-bgCard mt-auto relative z-10" wire:navigate>
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-textDim">
            <p class="font-mono">&copy; {{ date('Y') }} SYSRDMP. Crafted for Infrastructure Engineers.</p>
            <div class="flex space-x-6 mt-4 md:mt-0 font-bold font-mono">
                <a href="#" class="hover:text-accent">GITHUB</a>
                <a href="#" class="hover:text-accent">DISCORD</a>
                <a href="#" class="hover:text-accent">DASHBOARD</a>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
</body>
</html>
