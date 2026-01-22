<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="utf-8">
    <title>SAMARTH - करियर प्रोत्साहन</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#020617">
    <meta name="description" content="SAMARTH - युवाओं के लिए करियर प्रोत्साहन प्लेटफॉर्म">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Noto+Serif+Devanagari:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Outfit', 'sans-serif'],
                        serif: ['Noto Serif Devanagari', 'serif']
                    },
                    colors: {
                        space: {
                            dark: '#020617',
                            900: '#0f172a',
                            800: '#1e1b4b',
                            700: '#312e81',
                        },
                        saffron: {
                            500: '#f97316',
                            600: '#ea580c',
                        },
                        earth: {
                            saffron: '#ea580c',
                            gold: '#fbbf24',
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                        'pulse-slow': 'pulse 3s infinite',
                        'twinkle': 'twinkle 3s ease-in-out infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        twinkle: {
                            '0%, 100%': { opacity: '0.3', transform: 'scale(0.8)' },
                            '50%': { opacity: '1', transform: 'scale(1.2)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --space-dark: #020617;
            --space-blue: #1e1b4b;
            --earth-saffron: #ea580c;
            --neon-purple: #c084fc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', 'Noto Serif Devanagari', sans-serif;
            background-color: var(--space-dark);
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Space Background */
        .space-bg {
            position: fixed;
            inset: 0;
            z-index: -10;
            background: linear-gradient(180deg, #020617 0%, #0f172a 50%, #1e1b4b 100%);
        }

        /* Animated Stars */
        .star-field {
            position: fixed;
            inset: 0;
            z-index: -5;
            pointer-events: none;
            overflow: hidden;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle var(--duration, 3s) ease-in-out infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); box-shadow: 0 0 var(--glow, 3px) white; }
        }

        /* Nebula Effect */
        .nebula {
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            z-index: -6;
            pointer-events: none;
        }

        .nebula-1 {
            top: -200px;
            right: -100px;
            background: linear-gradient(135deg, #7c3aed, #2563eb, #06b6d4);
            animation: float 8s ease-in-out infinite;
        }

        .nebula-2 {
            bottom: -200px;
            left: -100px;
            background: linear-gradient(135deg, #ea580c, #f59e0b, #fbbf24);
            animation: float 10s ease-in-out infinite reverse;
        }

        /* Mountain Silhouette */
        .mountains {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 20vh;
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
        }

        .mountain-path {
            fill: none;
            stroke: rgba(255,255,255,0.1);
            stroke-width: 2;
        }

        /* Glassmorphism Header */
        .glass-header {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        /* Glass Cards */
        .glass-card {
            background: rgba(30, 27, 75, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .glass-card-hover {
            transition: all 0.3s ease;
        }

        .glass-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -12px rgba(234, 88, 12, 0.3);
            border-color: rgba(234, 88, 12, 0.3);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #ea580c 0%, #f59e0b 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Bottom Navigation */
        .bottom-nav {
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -4px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-item {
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .nav-item:hover, .nav-item.active {
            color: #ea580c;
        }

        .nav-item.active {
            text-shadow: 0 0 10px rgba(234, 88, 12, 0.5);
        }

        /* FAB Button */
        .fab {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            box-shadow: 0 4px 20px rgba(234, 88, 12, 0.4);
            transition: all 0.3s ease;
        }

        .fab:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 10px 40px rgba(234, 88, 12, 0.6);
        }

        /* Input Fields */
        .input-dark {
            background: rgba(2, 6, 23, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            transition: all 0.3s ease;
        }

        .input-dark:focus {
            border-color: #ea580c;
            box-shadow: 0 0 20px rgba(234, 88, 12, 0.2);
            outline: none;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(234, 88, 12, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 40px rgba(234, 88, 12, 0.5);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ea580c;
        }

        /* Cards */
        .card-dark {
            background: rgba(30, 27, 75, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .card-dark:hover {
            border-color: rgba(234, 88, 12, 0.3);
            transform: translateY(-5px);
        }

        /* Section Headers */
        .section-header {
            background: linear-gradient(135deg, #ea580c, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #ea580c;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        /* Hide scrollbar utility */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Story Ring for Profile */
        .story-ring {
            background: linear-gradient(135deg, #ea580c, #f97316, #fbbf24);
            padding: 2px;
            border-radius: 50%;
        }

        /* Status badges */
        .badge-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .badge-warning {
            background: rgba(234, 88, 12, 0.2);
            border: 1px solid rgba(234, 88, 12, 0.3);
            color: #ea580c;
        }

        .badge-info {
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #3b82f6;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Space Background -->
    <div class="space-bg"></div>
    
    <!-- Nebula Effects -->
    <div class="nebula nebula-1"></div>
    <div class="nebula nebula-2"></div>

    <!-- Star Field -->
    <div class="star-field" id="starField">
        <!-- Stars will be generated by JavaScript -->
    </div>

    <!-- Mountain Silhouette -->
    <svg class="mountains" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="rgba(255,255,255,0.05)" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>

    <!-- Main Container -->
    <div class="max-w-md mx-auto bg-space-dark/30 min-h-screen relative shadow-2xl overflow-hidden">
        
        <!-- Header -->
        <header class="glass-header fixed top-0 w-full max-w-md z-50 px-4 py-3 flex justify-between items-center transition-transform duration-300" id="main-header">
            <div class="flex items-center gap-3">
                <!-- SAMARTH Logo -->
                <svg width="40" height="40" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#ea580c" />
                            <stop offset="50%" style="stop-color:#f59e0b" />
                            <stop offset="100%" style="stop-color:#fbbf24" />
                        </linearGradient>
                        <filter id="glow">
                            <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                            <feMerge>
                                <feMergeNode in="coloredBlur"/>
                                <feMergeNode in="SourceGraphic"/>
                            </feMerge>
                        </filter>
                    </defs>
                    <circle cx="50" cy="50" r="45" fill="none" stroke="url(#logoGradient)" stroke-width="2" filter="url(#glow)"/>
                    <text x="50" y="60" text-anchor="middle" font-size="28" font-weight="900" fill="url(#logoGradient)" filter="url(#glow)">S</text>
                </svg>
                
@auth
                    @php
                        $user = auth()->user();
                        // Handle both array and object - prioritize first_name
                        if (is_array($user)) {
                            $firstName = $user['first_name'] ?? '';
                            $displayName = $firstName ?: ($user['username'] ?? 'User');
                        } else {
                            $firstName = $user->first_name ?? '';
                            $displayName = $firstName ?: ($user->username ?? 'User');
                        }
                        $hour = date('H');
                        $greeting = $hour < 12 ? 'सुप्रभात' : ($hour < 17 ? 'नमस्ते' : 'शुभ संध्या');
                    @endphp
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-400">{{ $greeting }}</span>
                        <span class="text-sm font-semibold text-white">{{ $displayName }}</span>
                    </div>
                @endauth
            </div>
            
            <div class="flex gap-4">
                <a href="{{ route('profile.notifications') }}" class="text-slate-400 hover:text-white transition-colors relative cursor-pointer">
                    <i class="far fa-bell text-xl"></i>
                    @auth
                    @php
                        $unreadCount = 0; // Replace with actual notification count logic
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-earth-saffron rounded-full text-[10px] flex items-center justify-center text-white font-bold">{{ $unreadCount }}</span>
                    @endif
                    @endauth
                </a>
                <a href="{{ route('profile.settings') }}" class="text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <i class="fas fa-cog text-xl"></i>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="pt-20 px-0 pb-24">
            @if(session('success'))
                <div class="mx-4 mb-4 p-4 glass-card rounded-xl text-sm animate-fade-in-up">
                    <div class="flex items-center gap-2 text-green-400">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            
            @if(isset($errors) && $errors->any())
                <div class="mx-4 mb-4 p-4 glass-card rounded-xl text-sm animate-fade-in-up">
                    <div class="flex items-center gap-2 text-red-400 font-bold mb-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>त्रुटि</span>
                    </div>
                    <ul class="list-disc pl-5 space-y-1 text-red-300">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </main>

        <!-- FAB Button Removed -->

        <!-- Bottom Navigation -->
        <nav class="bottom-nav fixed bottom-0 w-full max-w-md z-50 flex justify-around items-center py-3 px-2">
            <a href="{{ route('login') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('login') ? 'active' : '' }}">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <a href="{{ route('education.index') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('education.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap text-xl"></i>
            </a>
            
            <a href="{{ route('social.index') }}" class="nav-item flex flex-col items-center gap-1">
                <div class="w-12 h-12 bg-gradient-to-br from-earth-saffron to-orange-500 rounded-xl flex items-center justify-center shadow-lg transform -translate-y-2 hover:-translate-y-3 transition-transform">
                    <i class="fas fa-users text-white"></i>
                </div>
            </a>
            
            <a href="{{ route('challenges.index') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
                <i class="fas fa-trophy text-xl"></i>
            </a>
            
            <a href="{{ route('profile.show') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                @auth
                    @if(auth()->user()->profile && auth()->user()->profile->avatar)
                        <img src="{{ auth()->user()->profile->avatar }}" class="w-7 h-7 rounded-full border-2 border-earth-saffron object-cover">
                    @else
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-earth-saffron to-orange-500 flex items-center justify-center text-white text-sm font-bold">
                            {{ substr(optional(auth()->user())->username ?? 'U', 0, 1) }}
                        </div>
                    @endif
                @else
                    <i class="far fa-user-circle text-xl"></i>
                @endauth
            </a>
        </nav>

    </div>

    <script>
        // Generate Stars
        document.addEventListener('DOMContentLoaded', () => {
            const starField = document.getElementById('starField');
            const starCount = 80;
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.top = Math.random() * 100 + '%';
                star.style.left = Math.random() * 100 + '%';
                star.style.width = Math.random() * 3 + 1 + 'px';
                star.style.height = star.style.width;
                star.style.setProperty('--duration', (Math.random() * 3 + 2) + 's');
                star.style.setProperty('--glow', (Math.random() * 3 + 1) + 'px');
                star.style.animationDelay = Math.random() * 3 + 's';
                starField.appendChild(star);
            }

            // Header Scroll Effect
            let lastScroll = 0;
            const header = document.getElementById('main-header');
            
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                if (currentScroll > lastScroll && currentScroll > 50) {
                    header.style.transform = 'translateY(-100%)';
                } else {
                    header.style.transform = 'translateY(0)';
                }
                lastScroll = currentScroll;
            });

            // Pull-to-Refresh
            let touchStart = 0;
            let ptrDist = 0;
            const ptrThreshold = 150;
            
            document.addEventListener('touchstart', e => {
                if (window.scrollY === 0) touchStart = e.touches[0].clientY;
            });

            document.addEventListener('touchmove', e => {
                if (window.scrollY === 0 && touchStart > 0) {
                    const touchY = e.touches[0].clientY;
                    ptrDist = touchY - touchStart;
                    if (ptrDist > 0) {
                        header.style.transform = `translateY(${Math.min(ptrDist * 0.4, 80)}px)`;
                    }
                }
            });

            document.addEventListener('touchend', () => {
                header.style.transform = 'translateY(0)';
                if (ptrDist > ptrThreshold) {
                    header.innerHTML = '<div class="flex justify-center w-full py-2"><i class="fas fa-spinner fa-spin text-earth-saffron text-xl"></i></div>';
                    setTimeout(() => window.location.reload(), 500);
                }
                touchStart = 0;
                ptrDist = 0;
            });

            // Haptic Feedback
            const addHaptic = (el) => {
                el.addEventListener('click', () => {
                    if (navigator.vibrate) navigator.vibrate(10);
                });
            };
            
            document.querySelectorAll('a, button, .nav-item').forEach(addHaptic);
        });
    </script>
</body>
</html>
