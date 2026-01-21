@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Noto+Sans+Devanagari:wght@400;600;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Outfit', 'Noto Sans Devanagari', sans-serif;
        background-color: #020617; /* Deepest Slate */
        color: white;
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* --- MAGIC BACKGROUND --- */
    .magic-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background: radial-gradient(circle at 50% 0%, #1e1b4b, #020617); }
    
    /* Floating Orbs */
    .orb { position: absolute; border-radius: 50%; filter: blur(60px); opacity: 0.5; z-index: -1; animation: float 10s infinite ease-in-out; }
    .orb-1 { width: 300px; height: 300px; background: #a855f7; top: -10%; left: -10%; animation-delay: 0s; }
    .orb-2 { width: 400px; height: 400px; background: #ec4899; bottom: -10%; right: -10%; animation-delay: -5s; }
    @keyframes float { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(30px, 50px); } }

    /* Twinkling Stars (The "Blinking" Effect) */
    .star { position: absolute; background: white; border-radius: 50%; animation: twinkle var(--duration) infinite ease-in-out; opacity: 0; box-shadow: 0 0 10px white; }
    @keyframes twinkle { 0%, 100% { opacity: 0; transform: scale(0.5); } 50% { opacity: 0.8; transform: scale(1.2); } }

    /* --- GLASS CARD --- */
    .glass-prism {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255, 255, 255, 0.05);
        position: relative;
    }
    
    /* Glowing Border Animation */
    .glass-prism::before {
        content: ''; position: absolute; inset: -1px; z-index: -1; border-radius: 1.6rem;
        background: linear-gradient(45deg, #ec4899, #8b5cf6, #0ea5e9);
        opacity: 0.3; filter: blur(10px);
    }

    /* --- INPUTS --- */
    .input-field {
        width: 100%; background: rgba(2, 6, 23, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.8rem 0.8rem 0.8rem 2.8rem;
        border-radius: 0.8rem; color: white; outline: none; transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    .input-field:focus { 
        border-color: #d946ef; 
        background: rgba(2, 6, 23, 0.9); 
        box-shadow: 0 0 15px rgba(217, 70, 239, 0.2); 
    }
    .input-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; font-size: 0.9rem; transition: 0.3s; }
    .input-field:focus ~ .input-icon { color: #d946ef; filter: drop-shadow(0 0 5px #d946ef); }

    /* Section Headers */
    .neon-text { 
        font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8;
        margin: 1.5rem 0 0.8rem; display: flex; align-items: center; gap: 8px; font-weight: 700;
    }
    .neon-text::after { content: ''; height: 1px; flex: 1; background: linear-gradient(90deg, rgba(255,255,255,0.1), transparent); }

    /* Button */
    .magic-btn {
        background: linear-gradient(to right, #ec4899, #8b5cf6);
        position: relative; overflow: hidden; transition: all 0.3s;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .magic-btn:hover { 
        transform: translateY(-2px) scale(1.01); 
        box-shadow: 0 0 20px rgba(236, 72, 153, 0.5); 
    }
    
    /* Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
</style>

<div class="magic-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div style="position: fixed; width: 100%; height: 100%; pointer-events: none; z-index: -1;">
    <div class="star" style="top: 10%; left: 20%; width: 2px; height: 2px; --duration: 3s;"></div>
    <div class="star" style="top: 30%; left: 80%; width: 3px; height: 3px; --duration: 4s;"></div>
    <div class="star" style="top: 70%; left: 10%; width: 2px; height: 2px; --duration: 2.5s;"></div>
    <div class="star" style="top: 80%; left: 60%; width: 3px; height: 3px; --duration: 5s;"></div>
    <div class="star" style="top: 50%; left: 50%; width: 2px; height: 2px; --duration: 3.5s;"></div>
    <div class="star" style="top: 15%; left: 90%; width: 2px; height: 2px; --duration: 4.5s;"></div>
</div>

<div class="min-h-screen flex items-center justify-center p-4 py-12">
    <div class="glass-prism w-full max-w-lg rounded-3xl p-8 animate-[fadeInUp_0.8s_ease-out]">
        
        <div class="text-center mb-8 relative">
            <!-- SAMARTH Logo SVG - Smaller & Aligned -->
            <svg width="140" height="60" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto 1rem;">
                <defs>
                    <linearGradient id="registerLogoGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#2196F3" />
                        <stop offset="25%" style="stop-color:#9C27B0" />
                        <stop offset="50%" style="stop-color:#F44336" />
                        <stop offset="75%" style="stop-color:#FFEB3B" />
                        <stop offset="100%" style="stop-color:#4CAF50" />
                    </linearGradient>
                </defs>
                <g class="samarth-text">
                    <text x="50%" y="65%" text-anchor="middle" font-size="80" font-weight="900" 
                          style="font-family: 'Poppins', 'Arial Black', 'Helvetica Neue', sans-serif;"
                          fill="url(#registerLogoGradient)">
                        SAMARTH
                    </text>
                </g>
                <path d="M330 40 L370 20 L365 55" fill="none" stroke="url(#registerLogoGradient)" stroke-width="5" stroke-linecap="round"/>
            </svg>
            <h2 class="text-3xl font-black text-white mt-2 tracking-tight">Join <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-purple-400">SAMARTH</span></h2>
            <p class="text-slate-400 text-xs mt-2 uppercase tracking-widest">Begin Your Journey Today</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-900/30 border border-red-500/30 text-red-300 text-xs backdrop-blur-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="neon-text"><i class="fas fa-id-card text-pink-500"></i> Identity</div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="input-field" placeholder="First Name" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
                <div class="relative">
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="input-field" placeholder="Last Name" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="input-field cursor-pointer" required>
                    <i class="fas fa-calendar-day input-icon"></i>
                </div>
                <div class="relative">
                    <select name="gender" class="input-field appearance-none cursor-pointer" required>
                        <option value="" disabled selected class="bg-slate-900">Gender</option>
                        <option value="male" class="bg-slate-900">Male</option>
                        <option value="female" class="bg-slate-900">Female</option>
                        <option value="other" class="bg-slate-900">Other</option>
                    </select>
                    <i class="fas fa-venus-mars input-icon"></i>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="neon-text"><i class="fas fa-signal text-purple-500"></i> Connection</div>

            <div class="relative mb-4">
                <input type="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="Email Address" required>
                <i class="fas fa-envelope input-icon"></i>
            </div>

            <div class="relative mb-4">
                <input type="tel" name="phone" value="{{ old('phone') }}" class="input-field" placeholder="Mobile Number">
                <i class="fas fa-phone input-icon"></i>
            </div>

            <div class="neon-text"><i class="fas fa-shield-alt text-blue-500"></i> Security</div>

            <div class="relative mb-4">
                <input type="text" name="username" value="{{ old('username') }}" class="input-field" placeholder="Create Username" required>
                <i class="fas fa-at input-icon"></i>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="relative">
                    <input type="password" name="password" class="input-field" placeholder="Password" required minlength="6">
                    <i class="fas fa-lock input-icon"></i>
                </div>
                <div class="relative">
                    <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm" required>
                    <i class="fas fa-check-circle input-icon"></i>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-gradient-to-r from-slate-900/80 to-slate-800/80 border border-white/10 mb-6 relative overflow-hidden group">
                <div class="absolute inset-0 bg-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-center gap-2 mb-3 text-[11px] text-pink-300 font-bold uppercase tracking-wider">
                    <i class="fas fa-key"></i> Password Recovery Key
                </div>
                
                <div class="relative mb-3">
                    <select name="security_question" class="input-field appearance-none cursor-pointer" style="background: rgba(2,6,23,0.8);" required>
                        <option value="" disabled selected>Select Secret Question...</option>
                        <option value="mother" class="bg-slate-900">What is your mother's maiden name?</option>
                        <option value="father_city" class="bg-slate-900">What city was your father born in?</option>
                        <option value="pet" class="bg-slate-900">What was the name of your first pet?</option>
                        <option value="school" class="bg-slate-900">What was the name of your first school?</option>
                    </select>
                    <i class="fas fa-question-circle input-icon"></i>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-500 pointer-events-none"></i>
                </div>

                <div class="relative mb-0">
                    <input type="text" name="security_answer" class="input-field" style="background: rgba(2,6,23,0.8);" placeholder="Your Secret Answer" required>
                    <i class="fas fa-user-secret input-icon"></i>
                </div>
            </div>

            <div class="flex items-center gap-3 mb-6 pl-1">
                <div class="relative flex items-center">
                    <input type="checkbox" name="is_terms_accepted" id="terms" value="1" required 
                           class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-slate-500 checked:bg-pink-500 checked:border-pink-500 transition-all">
                    <i class="fas fa-check absolute left-[3px] top-[3px] text-[10px] text-white opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                </div>
                <label for="terms" class="text-xs text-slate-400 cursor-pointer select-none">
                    I agree to the <a href="#" class="text-pink-400 hover:text-pink-300 hover:underline">Terms</a> & <a href="#" class="text-pink-400 hover:text-pink-300 hover:underline">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="magic-btn w-full py-4 rounded-xl text-white font-bold text-lg tracking-wide mb-6">
                Create Universe <i class="fas fa-meteor ml-2"></i>
            </button>

        </form>

        <div class="text-center border-t border-white/10 pt-6">
            <p class="text-xs text-slate-400">
                Already have a universe? 
                <a href="{{ route('login') }}" class="text-white font-bold hover:text-pink-400 transition-colors ml-1 uppercase text-[10px] tracking-widest">
                    Enter Here
                </a>
            </p>
        </div>

    </div>
</div>

@endsection