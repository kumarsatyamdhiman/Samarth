@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { font-family: 'Outfit', sans-serif; background-color: #0f172a; overflow-x: hidden; }
    
    /* Background Animation */
    .animated-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, #1e1b4b, #0f172a); z-index: -2; }
    .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.6; animation: floatOrb 10s infinite ease-in-out; z-index: -1; }
    .orb-1 { width: 300px; height: 300px; background: #0ea5e9; top: -50px; right: -50px; }
    .orb-2 { width: 400px; height: 400px; background: #10b981; bottom: -100px; left: -100px; animation-delay: -5s; }
    @keyframes floatOrb { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(20px, 40px); } }

    /* Glass Card */
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    /* Inputs */
    .input-group { position: relative; margin-bottom: 1.25rem; }
    .input-field {
        width: 100%; background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 1rem 1rem 3rem;
        border-radius: 1rem; color: white; outline: none; transition: all 0.3s ease;
    }
    .input-field:focus { border-color: #10b981; background: rgba(15, 23, 42, 0.9); }
    .input-icon { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .input-field:focus ~ .input-icon { color: #10b981; }

    /* Button */
    .glow-btn {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        transition: all 0.3s;
    }
    .glow-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4); }
    
    /* Fade animation */
    .fade-in-up { animation: fadeInUp 0.5s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="animated-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-md rounded-3xl p-8 relative overflow-hidden fade-in-up">
        
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 via-blue-500 to-purple-600"></div>

        <div class="text-center mb-6">
            <!-- SAMARTH Logo SVG -->
            <svg width="140" height="60" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto 1rem;">
                <defs>
                    <linearGradient id="recoveryLogoGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#2196F3" />
                        <stop offset="25%" style="stop-color:#9C27B0" />
                        <stop offset="50%" style="stop-color:#F44336" />
                        <stop offset="75%" style="stop-color:#FFEB3B" />
                        <stop offset="100%" style="stop-color:#4CAF50" />
                    </linearGradient>
                </defs>
                <g class="samarth-text">
                    <text x="50%" y="65%" text-anchor="middle" font-size="100" font-weight="bold" 
                          style="font-family: 'Poppins', 'Arial Unicode MS', sans-serif;"
                          fill="url(#recoveryLogoGradient)">
                        समर्थ
                    </text>
                </g>
                <path d="M330 40 L370 20 L365 55" fill="none" stroke="url(#recoveryLogoGradient)" stroke-width="6" stroke-linecap="round"/>
            </svg>
            <h2 class="text-2xl font-bold text-white mt-2">खाता रिकवरी</h2>
            <p class="text-slate-400 text-xs mt-1">सुरक्षा प्रश्न का उत्तर दें</p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs flex items-center gap-2">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-3 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400 text-xs flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- STEP 1: Find User --}}
        @if(!session('security_question'))
            <form method="POST" action="{{ route('password.security.check') }}">
                @csrf
                <div class="input-group">
                    <input type="text" name="username" class="input-field" placeholder="अपना यूज़रनेम डालें" required>
                    <i class="fas fa-user input-icon"></i>
                </div>
                <button type="submit" class="glow-btn w-full py-3.5 rounded-xl text-white font-bold tracking-wide">
                    आगे बढ़ें <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
        @else
        {{-- STEP 2: Answer Question & Reset --}}
            <form method="POST" action="{{ route('password.security.reset') }}">
                @csrf
                <input type="hidden" name="username" value="{{ session('reset_username') }}">

                <div class="mb-6 p-4 bg-slate-800/50 border border-white/10 rounded-xl text-center">
                    <span class="text-xs text-slate-400 uppercase tracking-widest block mb-1">Security Question</span>
                    <p class="text-white font-semibold text-lg">
                        @if(session('security_question') == 'mother') माताजी का पहला नाम क्या है?
                        @elseif(session('security_question') == 'father_city') पिताजी का जन्म स्थान?
                        @elseif(session('security_question') == 'pet') पहले पालतू जानवर का नाम?
                        @elseif(session('security_question') == 'school') पहले स्कूल का नाम?
                        @else {{ session('security_question') }}
                        @endif
                    </p>
                </div>

                <div class="input-group">
                    <input type="text" name="security_answer" class="input-field" placeholder="उत्तर यहाँ लिखें" required autocomplete="off">
                    <i class="fas fa-key input-icon"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password" class="input-field" placeholder="नया पासवर्ड" required minlength="6">
                    <i class="fas fa-lock input-icon"></i>
                </div>

                <div class="input-group">
                    <input type="password" name="password_confirmation" class="input-field" placeholder="पासवर्ड पुष्टि करें" required>
                    <i class="fas fa-check-circle input-icon"></i>
                </div>

                <button type="submit" class="glow-btn w-full py-3.5 rounded-xl text-white font-bold tracking-wide">
                    पासवर्ड बदलें <i class="fas fa-check ml-2"></i>
                </button>
            </form>
        @endif

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-xs text-slate-500 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> लॉगिन पर वापस जाएं
            </a>
        </div>
    </div>
</div>
@endsection

