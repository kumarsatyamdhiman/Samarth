@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Noto Sans Devanagari', 'sans-serif'] },
                colors: {
                    brand: { 400: '#f472b6', 500: '#ec4899', 600: '#db2777' },
                    edu: { 400: '#818cf8', 500: '#6366f1' },
                },
                animation: {
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                }
            }
        }
    }
</script>

<style>
    body { background-color: #0f172a; color: white; -webkit-tap-highlight-color: transparent; font-family: 'Noto Sans Devanagari', sans-serif; }
    
    .bg-space {
        background-image: url('https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay;
        background-attachment: fixed;
    }

    .glass {
        background: rgba(30, 41, 59, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }

    /* Custom Radio/Checkbox Styles */
    .custom-radio:checked + div {
        background: rgba(236, 72, 153, 0.2);
        border-color: #ec4899;
        color: white;
    }
    .custom-radio:checked + div i { color: #f472b6; }
</style>

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div class="fixed top-0 left-0 right-0 z-40 flex justify-center">
        <div class="w-full max-w-md h-16 bg-slate-900/95 border-b border-white/10 flex items-center justify-between px-4 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="w-8 h-8 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="font-bold text-lg tracking-wide">Education Profile</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shadow-[0_0_10px_#10b981]">
                <i class="fas fa-user-check text-xs"></i>
            </div>
        </div>
    </div>

    <div class="w-full max-w-md mx-auto relative pt-20 px-4">

        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <div class="w-20 h-20 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-4 border-2 border-brand-500 shadow-lg shadow-brand-500/30">
                <i class="fas fa-user-edit text-3xl text-brand-400"></i>
            </div>
            <h1 class="text-2xl font-black mb-2 text-white">आपकी शिक्षा प्रोफ़ाइल</h1>
            <p class="text-slate-400 text-sm leading-relaxed">
                बेहतर करियर सुझाव पाने के लिए <br> अपनी जानकारी अपडेट करें।
            </p>
        </div>

        <div id="success-message" class="hidden mb-6 animate__animated animate__fadeIn">
            <div class="bg-green-500/20 border border-green-500/50 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white shrink-0">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <h3 class="font-bold text-white text-sm">प्रोफ़ाइल अपडेट हो गई!</h3>
                    <p class="text-xs text-green-300">अब आप 'My Plan' जनरेट कर सकते हैं।</p>
                </div>
            </div>
        </div>

        <form id="profileForm" onsubmit="saveProfile(event)" class="space-y-6">
            
            <div class="glass p-5 rounded-2xl border border-white/5 animate__animated animate__fadeInUp">
                <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
                    <i class="fas fa-school mr-2 text-brand-400"></i> आपकी कक्षा
                </h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['9th', '10th', '11th', '12th', 'Graduate'] as $cls)
                        <label class="cursor-pointer">
                            <input type="radio" name="current_class" value="{{ $cls }}" class="custom-radio hidden">
                            <div class="bg-slate-800 border border-white/10 rounded-xl p-3 text-center transition-all hover:bg-slate-700">
                                <span class="text-sm font-medium text-slate-300">{{ $cls }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="glass p-5 rounded-2xl border border-white/5 animate__animated animate__fadeInUp" style="animation-delay: 100ms;">
                <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
                    <i class="fas fa-layer-group mr-2 text-edu-400"></i> स्ट्रीम (Stream)
                </h2>
                <div class="space-y-3">
                    @php
                        $streams = [
                            ['id'=>'sci_pcm', 'icon'=>'fa-atom', 'name'=>'Science (PCM)', 'sub'=>'Engg & Tech'],
                            ['id'=>'sci_pcb', 'icon'=>'fa-dna', 'name'=>'Science (PCB)', 'sub'=>'Medical & Bio'],
                            ['id'=>'comm', 'icon'=>'fa-chart-line', 'name'=>'Commerce', 'sub'=>'Business & Finance'],
                            ['id'=>'arts', 'icon'=>'fa-palette', 'name'=>'Arts / Humanities', 'sub'=>'Civil Services & Law']
                        ];
                    @endphp
                    @foreach($streams as $stream)
                        <label class="cursor-pointer block">
                            <input type="radio" name="stream" value="{{ $stream['id'] }}" class="custom-radio hidden">
                            <div class="bg-slate-800 border border-white/10 rounded-xl p-3 flex items-center gap-3 transition-all hover:bg-slate-700">
                                <div class="w-10 h-10 rounded-lg bg-slate-900 flex items-center justify-center text-slate-400">
                                    <i class="fas {{ $stream['icon'] }}"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">{{ $stream['name'] }}</h4>
                                    <p class="text-[10px] text-slate-500">{{ $stream['sub'] }}</p>
                                </div>
                                <div class="ml-auto w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-brand-500 hidden check-dot"></div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="glass p-5 rounded-2xl border border-white/5 animate__animated animate__fadeInUp" style="animation-delay: 200ms;">
                <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
                    <i class="fas fa-bullseye mr-2 text-yellow-400"></i> मुख्य लक्ष्य (Goal)
                </h2>
                <input type="text" id="career_goal" placeholder="e.g. Become a Software Engineer" 
                       class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-500 focus:outline-none placeholder-slate-500">
            </div>

            <div class="pb-8 animate__animated animate__fadeInUp" style="animation-delay: 300ms;">
                <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-purple-600 py-4 rounded-xl font-bold text-white shadow-lg shadow-brand-500/30 active:scale-95 transition-transform flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Save Profile
                </button>
            </div>

        </form>

    </div>

</div>

<div class="fixed bottom-0 left-0 right-0 z-40 flex justify-center pb-safe">
    <div class="w-full max-w-md bg-slate-900/90 backdrop-blur-xl border-t border-white/10">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-home text-xl mb-1"></i><span class="text-[10px] font-medium">होम</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-brand-500">
                <i class="fas fa-graduation-cap text-xl mb-1"></i><span class="text-[10px] font-medium">कोर्स</span>
            </a>
            <div class="relative -top-5">
                <button class="w-14 h-14 rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/40 active:scale-90 transition-transform border-4 border-slate-900">
                    <i class="fas fa-plus text-xl"></i>
                </button>
            </div>
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-video text-xl mb-1"></i><span class="text-[10px] font-medium">वीडियो</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-user text-xl mb-1"></i><span class="text-[10px] font-medium">प्रोफाइल</span>
            </a>
        </div>
    </div>
</div>

<script>
    const PROFILE_KEY = 'samarth_user_profile';

    // 1. Load Data on Init
    document.addEventListener('DOMContentLoaded', () => {
        const savedData = localStorage.getItem(PROFILE_KEY);
        if (savedData) {
            const data = JSON.parse(savedData);
            
            // Set Class
            const classInput = document.querySelector(`input[name="current_class"][value="${data.class}"]`);
            if(classInput) classInput.checked = true;

            // Set Stream
            const streamInput = document.querySelector(`input[name="stream"][value="${data.stream}"]`);
            if(streamInput) {
                streamInput.checked = true;
                // Visually select radio parent styling manually if needed, 
                // but CSS :checked selector handles it
            }

            // Set Goal
            if(data.goal) document.getElementById('career_goal').value = data.goal;
        }
    });

    // 2. Save Data Function
    function saveProfile(e) {
        e.preventDefault();
        
        // Get Values
        const cls = document.querySelector('input[name="current_class"]:checked');
        const strm = document.querySelector('input[name="stream"]:checked');
        const goal = document.getElementById('career_goal').value;

        // Validation
        if (!cls || !strm) {
            alert("कृपया अपनी कक्षा और स्ट्रीम चुनें।");
            return;
        }

        // Save Object
        const profileData = {
            class: cls.value,
            stream: strm.value,
            goal: goal,
            updatedAt: new Date().toISOString()
        };

        localStorage.setItem(PROFILE_KEY, JSON.stringify(profileData));

        // Show Success UI
        const msg = document.getElementById('success-message');
        msg.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Optional: Redirect after delay
        // setTimeout(() => window.location.href = "{{ route('education.index') }}", 1500);
    }
</script>

<style>
    /* Radio Button Check Logic */
    .custom-radio:checked ~ div .check-dot { display: block; }
    .custom-radio:checked ~ div { border-color: #ec4899; background: rgba(236, 72, 153, 0.1); }
</style>

@endsection