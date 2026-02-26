<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — SYSRDMP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
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
                        accent:      '#00e5ff',
                        success:     '#9ece6a',
                    },
                    fontFamily: {
                        sans: ['Inter','sans-serif'],
                        mono: ['JetBrains Mono','monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        * { box-sizing: border-box; }
        body { background: #0f111a; margin: 0; font-family: 'Inter', sans-serif; }

        /* Animated grid background */
        .grid-bg {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(42,46,66,0.4) 1px, transparent 1px),
                linear-gradient(90deg, rgba(42,46,66,0.4) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        /* Pink glow blob */
        .glow-blob {
            position: fixed;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,0,127,0.12) 0%, transparent 70%);
            top: 50%; left: 50%;
            transform: translate(-50%, -60%);
            pointer-events: none; z-index: 0;
            animation: pulse-glow 4s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { transform: translate(-50%, -60%) scale(1); opacity: 0.8; }
            50%       { transform: translate(-50%, -60%) scale(1.15); opacity: 1; }
        }

        /* Scanline effect */
        .scanlines::after {
            content: '';
            position: fixed; inset: 0; z-index: 1;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,0.03) 2px,
                rgba(0,0,0,0.03) 4px
            );
            pointer-events: none;
        }

        /* Typewriter cursor blink */
        .cursor-blink { animation: blink 1s step-end infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

        .input-field {
            width: 100%;
            background: #0f111a;
            border: 1px solid #444b6a;
            color: #a9b1d6;
            border-radius: 8px;
            padding: 14px 16px 14px 48px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field:focus {
            border-color: #ff007f;
            box-shadow: 0 0 0 3px rgba(255,0,127,0.12), 0 0 20px rgba(255,0,127,0.08);
        }
        .input-field.error {
            border-color: #ff007f;
            box-shadow: 0 0 0 3px rgba(255,0,127,0.15);
        }
        .input-field::placeholder { color: #444b6a; }

        .btn-login {
            width: 100%;
            background: #ff007f;
            color: white;
            border: 1px solid #ff007f;
            border-radius: 8px;
            padding: 14px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.1em;
            box-shadow: 0 0 20px rgba(255,0,127,0.35);
            position: relative; overflow: hidden;
        }
        .btn-login:hover {
            background: #0f111a;
            color: #ff007f;
            box-shadow: 0 0 30px rgba(255,0,127,0.5);
        }
        .btn-login:active { transform: scale(0.98); }

        /* Shake animation on error */
        .shake { animation: shake 0.4s ease-in-out; }
        @keyframes shake {
            0%,100%{transform:translateX(0)}
            20%{transform:translateX(-8px)}
            40%{transform:translateX(8px)}
            60%{transform:translateX(-5px)}
            80%{transform:translateX(5px)}
        }
    </style>
</head>
<body class="scanlines">

    <div class="grid-bg"></div>
    <div class="glow-blob"></div>

    {{-- ── Centered login card ─────────────────────────────────────── --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md">

            {{-- Brand --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 border-2 border-primary rounded-xl font-mono font-black text-primary text-2xl shadow-[0_0_30px_rgba(255,0,127,0.4)] mb-4 bg-bgCard">
                    _
                </div>
                <h1 class="text-2xl font-black text-white font-mono tracking-tight">
                    sysrdmp<span class="text-primary">.admin</span>
                </h1>
                <p class="text-textDim font-mono text-xs mt-2 tracking-widest uppercase">
                    Restricted Access
                    <span class="cursor-blink text-primary">█</span>
                </p>
            </div>

            {{-- Card --}}
            <div id="login-card" class="bg-bgCard border border-borderSoft rounded-2xl overflow-hidden shadow-[0_0_60px_rgba(0,0,0,0.8)]">

                {{-- Terminal header bar --}}
                <div class="px-5 py-3 border-b border-borderSoft bg-bgElevated flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-success/80"></div>
                    </div>
                    <span class="text-textDim text-[10px] font-mono">admin@sysrdmp:~$ authenticate</span>
                    <div class="w-16"></div>
                </div>

                {{-- CLI intro text --}}
                <div class="px-6 pt-5 pb-2 font-mono text-xs space-y-1">
                    <p class="text-textDim"><span class="text-success">$</span> ssh admin@sysrdmp.docs</p>
                    <p class="text-textDim pl-4">→ Connecting to admin panel…</p>
                    <p class="text-textDim pl-4">→ Authentication required</p>
                </div>

                {{-- Form --}}
                <form id="login-form" method="POST" action="{{ route('admin.login.post') }}" class="px-6 pb-6 pt-3">
                    @csrf

                    {{-- Error state --}}
                    @if($errors->has('password'))
                    <div class="mb-4 flex items-center gap-2 bg-primary/10 border border-primary/30 rounded-lg px-4 py-3">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <p class="text-primary font-mono text-xs">{{ $errors->first('password') }}</p>
                    </div>
                    @endif

                    {{-- Logged out notice --}}
                    @if(session('logged_out'))
                    <div class="mb-4 flex items-center gap-2 bg-success/10 border border-success/30 rounded-lg px-4 py-3">
                        <svg class="w-4 h-4 text-success shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <p class="text-success font-mono text-xs">Session terminated. Goodbye.</p>
                    </div>
                    @endif

                    {{-- Password input --}}
                    <div class="mb-5">
                        <label class="block text-[10px] font-bold font-mono uppercase tracking-widest text-textDim mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-borderStrong" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="input-field {{ $errors->has('password') ? 'error' : '' }}"
                                   placeholder="Enter admin password"
                                   autocomplete="current-password"
                                   autofocus>
                            <button type="button"
                                    onclick="togglePassword()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-textDim hover:text-textNormal transition-colors">
                                <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" id="submit-btn" class="btn-login">
                        <span id="btn-text">ACCESS PANEL</span>
                    </button>

                    {{-- Divider --}}
                    <div class="mt-5 pt-4 border-t border-borderSoft">
                        <p class="text-center text-[10px] font-mono text-textDim">
                            Unauthorized access is prohibited.
                            <a href="{{ route('home') }}" class="text-accent hover:text-white transition-colors ml-1">← Back to site</a>
                        </p>
                    </div>
                </form>
            </div>

            {{-- Bottom clue --}}
            <p class="text-center text-[10px] font-mono text-textDim mt-6 opacity-50">
                SYSRDMP Admin Panel · Protected Route
            </p>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
            }
        }

        // Shake card on error
        @if($errors->has('password'))
        document.getElementById('login-card').classList.add('shake');
        setTimeout(() => document.getElementById('login-card').classList.remove('shake'), 500);
        @endif

        // Loading state on submit
        document.getElementById('login-form').addEventListener('submit', function() {
            const btn  = document.getElementById('submit-btn');
            const text = document.getElementById('btn-text');
            btn.disabled = true;
            btn.style.opacity = '0.7';
            text.textContent  = 'AUTHENTICATING...';
        });
    </script>
</body>
</html>
