@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&family=Noto+Serif+Devanagari:wght@400;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --space-dark: #020617;
        --space-blue: #1e1b4b;
        --earth-saffron: #ea580c; /* Bundelkhand Earth Tone */
        --neon-purple: #c084fc;
    }

    body {
    font-family: 'Outfit', 'Noto Serif Devanagari', sans-serif;
    background-color: var(--space-dark);
    color: Dark;
    /* Remove overflow: hidden; height: 100vh; - let it flow naturally */
    min-height: 100vh; /* Ensures full viewport minimum */
}

    /* --- BACKGROUND MAGIC --- */
    .cosmos-bg {
        position: fixed; inset: 0; z-index: -10;
        background: radial-gradient(circle at 50% 100%, #172554 0%, #020617 70%);
    }

    /* Stars */
    .star-field { position: fixed; inset: 0; z-index: -5; pointer-events: none; }
    .star {
        position: absolute; background: white; border-radius: 50%;
        animation: twinkle var(--duration) infinite ease-in-out;
        box-shadow: 0 0 var(--glow) white;
    }
    @keyframes twinkle { 0%, 100% { opacity: 0.3; transform: scale(0.8); } 50% { opacity: 1; transform: scale(1.2); } }

    /* Shooting Star */
    .shooting-star {
        position: absolute; top: 50%; left: 50%; width: 4px; height: 4px;
        background: #fff; border-radius: 50%;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1), 0 0 0 8px rgba(255, 255, 255, 0.1), 0 0 20px rgba(255, 255, 255, 1);
        animation: shoot 5s linear infinite; opacity: 0;
    }
    .shooting-star::before {
        content: ''; position: absolute; top: 50%; transform: translateY(-50%); width: 300px; height: 1px;
        background: linear-gradient(90deg, #fff, transparent); left: 1px;
    }
    @keyframes shoot { 0% { transform: rotate(315deg) translateX(0); opacity: 1; } 70% { opacity: 1; } 100% { transform: rotate(315deg) translateX(-1000px); opacity: 0; } }

    /* Bundelkhand Silhouette Landscape */
    .landscape {
        position: fixed; bottom: 0; left: 0; width: 100%; height: 25vh;
        background-image: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxNDQwIDMyMCI+PHBhdGggZmlsbD0iIzBhMGEwYSIgZmlsbC1vcGFjaXR5PSIxIiBkPSJNMCAyMjRMNDAgMTkyTDgwIDIwOEwxMjAgMjU2TDE2MCAxOTJMMjAwIDIyNEwyNDAgMTYwTDI4MCAxOTJMMzIwIDI1NkwzNjAgMjI0TDQwMCAxOTJMNDQwIDI1Nkw0ODAgMjI0TDUyMCAyODhMNTYwIDI1Nkw2MDAgMjI0TDY0MCAxOTJMNjgwIDIyNEw3MjAgMjU2TDc2MCAyODhMNDgwIDMyMEw4NDAgMzIwTDg4MCAzMjBMOTIwIDMyMEw5NjAgMzIwTDEwMDAgMzIwTDEwNDAgMzIwTDEwODAgMzIwTDExMjAgMzIwTDExNjAgMzIwTDEyMDAgMzIwTDEyNDAgMzIwTDEyODAgMzIwTDEzMjAgMzIwTDEzNjAgMzIwTDE0MDAgMzIwTDE0NDAgMzIwTDE0NDAgMzIwWiI+PC9wYXRoPjwvc3ZnPg==');
        background-repeat: no-repeat; background-size: cover; background-position: bottom;
        z-index: -1; opacity: 0.6; pointer-events: none;
    }
    /* Adding a Fort-like structure overlay */
    .fort-silhouette {
        position: fixed; bottom: 0; right: 10%; width: 200px; height: 150px;
        background: #050505;
        clip-path: polygon(10% 100%, 10% 40%, 20% 40%, 20% 20%, 30% 20%, 30% 40%, 40% 40%, 40% 10%, 50% 10%, 50% 40%, 60% 40%, 60% 20%, 70% 20%, 70% 40%, 80% 40%, 80% 100%);
        z-index: -1;
    }

    /* --- TRANSITIONS --- */
    .page-section {
        position: absolute; inset: 0;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        transition: transform 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55), opacity 0.8s ease;
        padding: 1.5rem;
    }
    .page-hidden-up { transform: translateY(-100vh) scale(0.8); opacity: 0; pointer-events: none; }
    .page-active { transform: translateY(0) scale(1); opacity: 1; pointer-events: auto; }
    .page-hidden-down { transform: translateY(100vh) scale(0.8); opacity: 0; pointer-events: none; }

    /* --- GLASS UI --- */
    .glass-card {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Mobile transparent card */
    @media (max-width: 640px) {
        .glass-card {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 15px 30px -8px rgba(0, 0, 0, 0.3);
        }
    }

    /* --- TYPOGRAPHY --- */
    .gradient-text { 
        background: linear-gradient(to right, #ea580c, #fbbf24, #fcd34d); /* Saffron to Gold */
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; 
        text-shadow: 0 0 20px rgba(234, 88, 12, 0.3);
    }

    .input-field {
        width: 100%; background: rgba(2, 6, 23, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 1rem 1rem 1rem 3rem;
        border-radius: 0.75rem; color: white; outline: none; transition: all 0.3s;
    }
    .input-field:focus { 
        border-color: var(--earth-saffron); 
        background: rgba(2, 6, 23, 0.9); 
        box-shadow: 0 0 15px rgba(234, 88, 12, 0.3); 
    }
    .input-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; transition: 0.3s; }
    .input-field:focus ~ .input-icon { color: var(--earth-saffron); }

    .magic-btn {
        background: linear-gradient(135deg, #ea580c 0%, #db2777 100%);
        position: relative; overflow: hidden; transition: all 0.3s;
        box-shadow: 0 4px 20px rgba(234, 88, 12, 0.4);
    }
    .magic-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 40px rgba(234, 88, 12, 0.6); }
    
    .outline-btn {
        background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.15); transition: 0.3s;
    }
    .outline-btn:hover { background: rgba(255,255,255,0.15); border-color: white; }
</style>

<div class="cosmos-bg"></div>
<div class="landscape"></div>
<div class="fort-silhouette"></div>

<!-- Star Field - Enhanced for Mobile -->
<div class="star-field">
    <!-- Shooting Star -->
    <div class="shooting-star" style="top: 20%; left: 80%;"></div>
    
    <!-- Desktop Stars (Original) -->
    <div class="star" style="top: 10%; left: 15%; width: 2px; height: 2px; --duration: 3s; --glow: 2px;"></div>
    <div class="star" style="top: 20%; left: 85%; width: 3px; height: 3px; --duration: 4s; --glow: 4px;"></div>
    <div class="star" style="top: 60%; left: 25%; width: 2px; height: 2px; --duration: 2.5s; --glow: 2px;"></div>
    <div class="star" style="top: 80%; left: 60%; width: 2px; height: 2px; --duration: 5s; --glow: 3px;"></div>
    <div class="star" style="top: 40%; left: 50%; width: 3px; height: 3px; --duration: 3.5s; --glow: 5px;"></div>
    <div class="star" style="top: 15%; left: 50%; width: 1px; height: 1px; --duration: 2s; --glow: 1px;"></div>
    
    <!-- Mobile-Optimized Stars - More stars at different positions -->
    <div class="star" style="top: 5%; left: 10%; width: 2px; height: 2px; --duration: 2.5s; --glow: 3px;"></div>
    <div class="star" style="top: 8%; left: 30%; width: 1px; height: 1px; --duration: 3s; --glow: 2px;"></div>
    <div class="star" style="top: 12%; left: 70%; width: 2px; height: 2px; --duration: 4s; --glow: 3px;"></div>
    <div class="star" style="top: 25%; left: 5%; width: 2px; height: 2px; --duration: 2.8s; --glow: 2px;"></div>
    <div class="star" style="top: 30%; left: 25%; width: 3px; height: 3px; --duration: 3.5s; --glow: 4px;"></div>
    <div class="star" style="top: 35%; left: 75%; width: 1px; height: 1px; --duration: 2.2s; --glow: 1px;"></div>
    <div class="star" style="top: 45%; left: 10%; width: 2px; height: 2px; --duration: 3.8s; --glow: 3px;"></div>
    <div class="star" style="top: 50%; left: 35%; width: 3px; height: 3px; --duration: 4.2s; --glow: 5px;"></div>
    <div class="star" style="top: 55%; left: 90%; width: 2px; height: 2px; --duration: 2.6s; --glow: 2px;"></div>
    <div class="star" style="top: 65%; left: 15%; width: 1px; height: 1px; --duration: 3.2s; --glow: 2px;"></div>
    <div class="star" style="top: 70%; left: 45%; width: 2px; height: 2px; --duration: 4.5s; --glow: 3px;"></div>
    <div class="star" style="top: 75%; left: 80%; width: 3px; height: 3px; --duration: 2.9s; --glow: 4px;"></div>
    <div class="star" style="top: 85%; left: 5%; width: 2px; height: 2px; --duration: 3.4s; --glow: 3px;"></div>
    <div class="star" style="top: 90%; left: 30%; width: 1px; height: 1px; --duration: 2.4s; --glow: 1px;"></div>
    <div class="star" style="top: 95%; left: 70%; width: 2px; height: 2px; --duration: 3.6s; --glow: 2px;"></div>
    
    <!-- Extra small stars for depth -->
    <div class="star" style="top: 3%; left: 90%; width: 1px; height: 1px; --duration: 5s; --glow: 1px;"></div>
    <div class="star" style="top: 18%; left: 60%; width: 1px; height: 1px; --duration: 3.8s; --glow: 1px;"></div>
    <div class="star" style="top: 28%; left: 95%; width: 1px; height: 1px; --duration: 4.2s; --glow: 1px;"></div>
    <div class="star" style="top: 38%; left: 20%; width: 1px; height: 1px; --duration: 2.8s; --glow: 1px;"></div>
    <div class="star" style="top: 48%; left: 65%; width: 1px; height: 1px; --duration: 3.5s; --glow: 1px;"></div>
    <div class="star" style="top: 58%; left: 40%; width: 1px; height: 1px; --duration: 4.8s; --glow: 1px;"></div>
    <div class="star" style="top: 68%; left: 5%; width: 1px; height: 1px; --duration: 2.5s; --glow: 1px;"></div>
    <div class="star" style="top: 78%; left: 35%; width: 1px; height: 1px; --duration: 3.2s; --glow: 1px;"></div>
    <div class="star" style="top: 88%; left: 55%; width: 1px; height: 1px; --duration: 4s; --glow: 1px;"></div>
    <div class="star" style="top: 98%; left: 85%; width: 1px; height: 1px; --duration: 2.7s; --glow: 1px;"></div>
</div>

<div id="welcome-section" class="page-section page-active">
    <div class="max-w-2xl text-center relative z-10">
        
        

        <h1 class="text-6xl md:text-7xl font-black text-white mb-6 leading-tight tracking-tight drop-shadow-2xl">
            बुन्देलखंड से <br>
            <span class="gradient-text">आसमान तक</span>
        </h1>

        <div class="space-y-6 mb-12">
            <p class="text-xl md:text-2xl text-slate-200 font-serif italic border-l-4 border-orange-500 pl-4 inline-block text-left">
                "आपकी मेहनत ही आपकी पहचान है,<br> वरना एक नाम के तो लाखों इंसान हैं।"
            </p>
            <p class="text-slate-400 text-sm font-light uppercase tracking-[0.2em] mt-4">
                Be the pride of your soil. Reach for the stars.
            </p>
        </div>

        <button onclick="showLogin()" class="magic-btn px-12 py-5 rounded-full text-white font-bold text-lg tracking-widest uppercase group border border-white/20">
            Start Journey 
            <i class="fas fa-arrow-up ml-2 group-hover:translate-y-[-4px] transition-transform"></i>
        </button>
        
        <div class="absolute bottom-[-100px] left-0 right-0 text-center opacity-40 text-[10px] uppercase tracking-[0.3em]">
            Samarth Platform © 2026
        </div>
    </div>
</div>

<div id="login-section" class="page-section page-hidden-down">
    <div class="glass-card w-full max-w-md rounded-3xl p-8 md:p-10 relative">
        
        <button onclick="showWelcome()" class="absolute top-6 left-6 text-slate-400 hover:text-white transition-colors flex items-center gap-2 text-xs uppercase tracking-wider font-bold">
            <i class="fas fa-arrow-down"></i> Back to Earth
        </button>

        <div class="text-center mb-8 mt-4">
            <h2 class="text-3xl font-bold text-white">Login</h2>
            <p class="text-slate-400 text-sm mt-1">Unlock your future.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs text-center flex items-center justify-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            
            <div class="relative mb-4">
                <input type="text" name="username" class="input-field" placeholder="Username" required autocomplete="off">
                <i class="fas fa-user input-icon"></i>
            </div>

            <div class="relative mb-6">
                <input type="password" name="password" id="password" class="input-field" placeholder="Password" required>
                <i class="fas fa-lock input-icon"></i>
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-white transition-colors">
                    <i class="fas fa-eye" id="eyeIcon"></i>
                </button>
            </div>

            <div class="flex justify-between items-center mb-8 text-xs text-slate-400">
                <label class="flex items-center gap-2 cursor-pointer hover:text-white transition-colors">
                    <input type="checkbox" class="accent-orange-500 rounded"> Remember me
                </label>
                <a href="{{ route('password.security.request') }}" class="hover:text-orange-400 transition-colors">Forgot Password?</a>
            </div>

            <button type="submit" class="magic-btn w-full py-4 rounded-xl text-white font-bold text-lg tracking-wide mb-6 shadow-lg">
                Login <i class="fas fa-sign-in-alt ml-2"></i>
            </button>

        </form>

        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-white/10">
            <a href="{{ route('public.goals') }}" class="outline-btn w-full py-3 rounded-xl text-white text-xs font-bold text-center uppercase tracking-wide">
                Guest Mode
            </a>
            <a href="{{ route('register.show') }}" class="outline-btn w-full py-3 rounded-xl text-white text-xs font-bold text-center uppercase tracking-wide">
                Register
            </a>
        </div>

    </div>
</div>

<script>
    function showLogin() {
        // Animation: Rocket Launch Effect (Slide Up)
        document.getElementById('welcome-section').classList.replace('page-active', 'page-hidden-up');
        document.getElementById('login-section').classList.replace('page-hidden-down', 'page-active');
    }

    function showWelcome() {
        // Animation: Landing Effect (Slide Down)
        document.getElementById('login-section').classList.replace('page-active', 'page-hidden-down');
        document.getElementById('welcome-section').classList.replace('page-hidden-up', 'page-active');
    }

    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

@endsection