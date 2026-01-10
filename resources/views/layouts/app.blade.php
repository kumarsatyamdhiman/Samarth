<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="utf-8">
    <title>SAMARTH - करियर प्रोत्साहन</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="theme-color" content="#833ab4">
    <meta name="description" content="SAMARTH - युवाओं के लिए करियर प्रोत्साहन प्लेटफॉर्म">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        insta: {
                            purple: '#833ab4',
                            pink: '#fd1d1d',
                            yellow: '#fcb045',
                            blue: '#0095f6'
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Glassmorphism & Utilities */
        body { background-color: #fafafa; -webkit-tap-highlight-color: transparent; }
        
        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .text-gradient {
            background: linear-gradient(45deg, #833ab4, #fd1d1d, #fcb045);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .bottom-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .nav-item.active { color: #000; }
        .nav-item { color: #8e8e8e; transition: transform 0.1s; }
        .nav-item:active { transform: scale(0.9); }

        /* Story Ring Animation */
        .story-ring {
            background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            padding: 2px;
            border-radius: 50%;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .story-ring:hover { transform: scale(1.1) rotate(5deg); }

        /* Floating Action Button */
        .fab {
            background: linear-gradient(135deg, #833ab4, #fd1d1d);
            box-shadow: 0 4px 15px rgba(253, 29, 29, 0.4);
            transition: transform 0.2s;
        }
        .fab:active { transform: scale(0.95); }

        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased text-gray-900 pb-20 opacity-0 transition-opacity duration-500" onload="document.body.classList.remove('opacity-0')">

    <div class="max-w-md mx-auto bg-white min-h-screen relative shadow-2xl overflow-hidden">
        
        <header class="glass-header fixed top-0 w-full max-w-md z-50 px-4 py-3 flex justify-between items-center transition-transform duration-300" id="main-header">
            <div>
                <h1 class="text-2xl font-bold text-gradient cursor-pointer" onclick="window.scrollTo({top:0, behavior:'smooth'})">SAMARTH</h1>
                @auth
                    @php
                        $user = auth()->user();
                        $displayName = $user->profile && $user->profile->display_name ? $user->profile->display_name : $user->username;
                        $hour = date('H');
                        $greeting = $hour < 12 ? 'सुप्रभात' : ($hour < 17 ? 'नमस्ते' : 'शुभ संध्या');
                    @endphp
                    <div class="text-xs font-medium text-gray-500 animate-fade-in-up">
                        {{ $greeting }}, {{ $displayName }} ✨
                    </div>
                @endauth
            </div>
            <div class="flex gap-5 text-gray-600">
                <div class="relative cursor-pointer hover:text-black transition-colors">
                    <i class="far fa-heart text-xl"></i>
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </div>
                <div class="relative cursor-pointer hover:text-black transition-colors">
                    <i class="far fa-paper-plane text-xl"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">3</span>
                </div>
            </div>
        </header>

        <main class="pt-20 px-0">
            @if(session('success'))
                <div class="mx-4 mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2 animate-fade-in-up shadow-sm">
                    <i class="fas fa-check-circle text-lg"></i> {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="mx-4 mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm animate-fade-in-up shadow-sm">
                    <div class="flex items-center gap-2 font-bold mb-1"><i class="fas fa-exclamation-circle"></i> त्रुटि</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </main>

        <div class="fixed bottom-24 right-4 z-40 max-w-md mx-auto w-full flex justify-end pr-4 pointer-events-none">
            <button onclick="location.href='{{ Route::has('goals.create') ? route('goals.create') : route('goals.index') }}'" class="fab pointer-events-auto w-14 h-14 rounded-full flex items-center justify-center text-white text-2xl hover:scale-110 active:scale-95 transition-all focus:outline-none focus:ring-4 focus:ring-purple-300">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <nav class="bottom-nav fixed bottom-0 w-full max-w-md z-50 flex justify-around items-center py-3">
            <a href="{{ route('home') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="{{ request()->routeIs('home') ? 'fas' : 'fas' }} fa-home text-xl"></i>
            </a>
            
            <a href="{{ route('education.index') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('education.*') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap text-xl"></i>
            </a>
            
            <a href="{{ route('goals.index') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                <div class="w-10 h-10 bg-black text-white rounded-xl flex items-center justify-center shadow-lg transform -translate-y-2 hover:-translate-y-3 transition-transform">
                    <i class="fas fa-bullseye"></i>
                </div>
            </a>
            
            <a href="{{ route('challenges.index') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('challenges.*') ? 'active' : '' }}">
                <i class="fas fa-trophy text-xl"></i>
            </a>
            
            <a href="{{ route('profile.show') }}" class="nav-item flex flex-col items-center gap-1 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                @auth
                    @if(auth()->user()->profile && auth()->user()->profile->avatar)
                        <img src="{{ auth()->user()->profile->avatar }}" class="w-6 h-6 rounded-full border border-gray-300 object-cover">
                    @else
                        <div class="w-6 h-6 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-[10px]">
                            {{ substr(auth()->user()->username, 0, 1) }}
                        </div>
                    @endif
                @else
                    <i class="far fa-user-circle text-xl"></i>
                @endauth
            </a>
        </nav>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Header Scroll Effect
            let lastScroll = 0;
            const header = document.getElementById('main-header');
            
            window.addEventListener('scroll', () => {
                const currentScroll = window.pageYOffset;
                if (currentScroll > lastScroll && currentScroll > 50) {
                    header.style.transform = 'translateY(-100%)'; // Hide on scroll down
                } else {
                    header.style.transform = 'translateY(0)'; // Show on scroll up
                }
                lastScroll = currentScroll;
            });

            // 2. Pull-to-Refresh Simulation
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
                    // Visual feedback for refresh
                    header.innerHTML = '<div class="flex justify-center w-full py-2"><i class="fas fa-spinner fa-spin text-purple-600"></i></div>';
                    setTimeout(() => window.location.reload(), 500);
                }
                touchStart = 0;
                ptrDist = 0;
            });

            // 3. Haptic Feedback (Vibration)
            const addHaptic = (el) => {
                el.addEventListener('click', () => {
                    if (navigator.vibrate) navigator.vibrate(10); // Light tap
                });
            };
            
            document.querySelectorAll('a, button, .nav-item').forEach(addHaptic);
        });
    </script>
</body>
</html>