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
                    science: { 400: '#60a5fa', 500: '#3b82f6', 900: '#1e3a8a' }, // Blue
                    commerce: { 400: '#fbbf24', 500: '#f59e0b', 900: '#78350f' }, // Amber
                    arts: { 400: '#a78bfa', 500: '#8b5cf6', 900: '#4c1d95' }, // Purple
                },
                animation: {
                    'float': 'float 4s ease-in-out infinite',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                },
                keyframes: {
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

    .neon-text { text-shadow: 0 0 15px rgba(236, 72, 153, 0.6); }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    
    /* Transitions */
    .view-transition { transition: opacity 0.3s ease, transform 0.3s ease; }
    .hidden-view { display: none; opacity: 0; pointer-events: none; }
    .active-view { display: block; opacity: 1; pointer-events: auto; }

    /* Tab Active State */
    .tab-active { color: #f472b6; border-bottom: 2px solid #f472b6; }
    .tab-inactive { color: #94a3b8; border-bottom: 2px solid transparent; }
</style>

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div id="main-view" class="w-full max-w-md mx-auto relative pt-20 px-4 active-view">
        
        <div class="fixed top-0 left-0 right-0 z-40 flex justify-center">
            <div class="w-full max-w-md h-16 bg-slate-900/95 border-b border-white/10 flex items-center justify-between px-4 backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="w-8 h-8 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <span class="font-bold text-lg tracking-wide">Stream Selector</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center shadow-[0_0_10px_#ec4899]">
                    <i class="fas fa-user-graduate text-xs"></i>
                </div>
            </div>
        </div>

        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-3xl font-black mb-2 leading-tight">
                <span class="block text-white">सही स्ट्रीम</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-500 neon-text">
                    कैसे चुनें?
                </span>
            </h1>
            <p class="text-slate-400 text-sm">
                अपनी ताकत और सपनों के आधार पर <br>भविष्य का पहला कदम उठाएं।
            </p>
        </div>

        <div class="mb-8 animate__animated animate__zoomIn">
            <div class="flex items-center justify-between mb-3 px-1">
                <h2 class="text-sm font-bold text-brand-400 uppercase tracking-wider">
                    <i class="fas fa-robot mr-1"></i> AI सुझाव
                </h2>
                <span class="text-[10px] bg-brand-500/20 text-brand-400 px-2 py-1 rounded-full border border-brand-500/30">
                    Top Match
                </span>
            </div>
            
            <div class="glass p-5 rounded-2xl border-l-4 border-science-500 relative overflow-hidden group">
                <div class="absolute right-0 top-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fas fa-atom text-6xl text-science-400"></i>
                </div>
                
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-science-500/20 flex items-center justify-center text-science-400 border border-science-500/30">
                        <i class="fas fa-microchip text-xl"></i>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-black text-white">95%</div>
                        <div class="text-[10px] text-slate-400 uppercase">Match Score</div>
                    </div>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-1">Science (PCM)</h3>
                <p class="text-slate-300 text-sm mb-4 leading-relaxed">
                    आपकी लॉजिकल रीजनिंग और तकनीकी समझ अद्भुत है। इंजीनियरिंग या टेक्नोलॉजी आपके लिए बेस्ट है।
                </p>

                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-300 border border-white/5">Physics</span>
                    <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-300 border border-white/5">Maths</span>
                    <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-300 border border-white/5">Coding</span>
                </div>

                <button onclick="openStreamDetail('science_pcm')" class="w-full bg-gradient-to-r from-science-500 to-blue-600 py-3 rounded-xl font-bold text-white shadow-lg shadow-blue-500/30 active:scale-95 transition-transform flex items-center justify-center gap-2">
                    Explore PCM Careers <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-1">
                <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider">
                    <i class="fas fa-layer-group mr-1"></i> अन्य विकल्प
                </h2>
            </div>

            <button onclick="openStreamDetail('science_pcb')" class="w-full text-left glass p-4 rounded-2xl border border-white/5 hover:border-brand-500/50 transition-all animate__animated animate__fadeInUp">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/10 flex items-center justify-center shrink-0 border border-brand-500/20">
                        <i class="fas fa-dna text-brand-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white text-lg">Science (PCB)</h3>
                        <p class="text-xs text-slate-400">Medical, Biotech & Research</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-500"></i>
                </div>
            </button>

            <button onclick="openStreamDetail('commerce')" class="w-full text-left glass p-4 rounded-2xl border border-white/5 hover:border-commerce-500/50 transition-all animate__animated animate__fadeInUp" style="animation-delay: 100ms;">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-xl bg-commerce-500/10 flex items-center justify-center shrink-0 border border-commerce-500/20">
                        <i class="fas fa-chart-line text-commerce-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white text-lg">Commerce</h3>
                        <p class="text-xs text-slate-400">Business, Finance & CA</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-500"></i>
                </div>
            </button>

            <button onclick="openStreamDetail('arts')" class="w-full text-left glass p-4 rounded-2xl border border-white/5 hover:border-arts-500/50 transition-all animate__animated animate__fadeInUp" style="animation-delay: 200ms;">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 rounded-xl bg-arts-500/10 flex items-center justify-center shrink-0 border border-arts-500/20">
                        <i class="fas fa-palette text-arts-400 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-white text-lg">Arts / Humanities</h3>
                        <p class="text-xs text-slate-400">UPSC, Law & Design</p>
                    </div>
                    <i class="fas fa-chevron-right text-slate-500"></i>
                </div>
            </button>
        </div>

        <div class="mt-10 mb-6">
            <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4 px-1">
                <i class="fas fa-lightbulb mr-1 text-yellow-400"></i> एक्सपर्ट टिप्स
            </h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="glass p-3 rounded-xl border border-white/5 text-center">
                    <div class="w-8 h-8 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-2 text-yellow-400">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white mb-1">रुचि (Interest)</h4>
                    <p class="text-[10px] text-slate-400">वही चुनें जो पढ़ना पसंद हो, दबाव में नहीं।</p>
                </div>
                <div class="glass p-3 rounded-xl border border-white/5 text-center">
                    <div class="w-8 h-8 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-2 text-green-400">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white mb-1">करियर स्कोप</h4>
                    <p class="text-[10px] text-slate-400">अगले 5-10 सालों की डिमांड देखें।</p>
                </div>
            </div>
        </div>

        <div class="glass p-6 rounded-2xl text-center border border-brand-500/30 relative overflow-hidden mb-20">
            <div class="absolute inset-0 bg-brand-500/5"></div>
            <h3 class="text-lg font-bold text-white mb-2 relative z-10">अभी भी कन्फ्यूज हैं?</h3>
            <p class="text-sm text-slate-300 mb-4 relative z-10">हमारे काउंसलर से बात करें और सही मार्गदर्शन पाएं।</p>
            <button onclick="openCounselorModal()" class="w-full bg-slate-800 text-white py-3 rounded-xl font-bold border border-white/10 hover:bg-slate-700 transition-colors relative z-10">
                <i class="fas fa-headset mr-2 text-brand-400"></i> काउंसलर से बात करें
            </button>
        </div>
    </div>

    <div id="detail-view" class="w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space overflow-y-auto hidden-view">
        
        <div class="sticky top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-xl border-b border-white/10 p-4 flex items-center gap-4">
            <button onclick="closeStreamDetail()" class="w-10 h-10 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-white active:scale-90 transition-transform">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2 id="detail-title" class="font-bold text-lg text-white">Stream Details</h2>
        </div>

        <div id="detail-hero-bg" class="h-48 w-full bg-gradient-to-br from-blue-600 to-slate-900 relative p-6 flex flex-col justify-end">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="relative z-10">
                <span id="detail-category" class="text-xs bg-white/20 px-2 py-1 rounded text-white mb-2 inline-block backdrop-blur-sm">Engineering</span>
                <h1 id="detail-name" class="text-3xl font-black text-white mb-1">Science (PCM)</h1>
                <p id="detail-desc" class="text-sm text-slate-200">The gateway to innovation.</p>
            </div>
        </div>

        <div class="flex border-b border-white/10 bg-slate-900/90 sticky top-16 z-40 overflow-x-auto no-scrollbar">
            <button id="tab-btn-overview" onclick="switchTab('overview')" class="flex-1 py-3 px-4 text-sm font-bold tab-active whitespace-nowrap transition-colors">Overview</button>
            <button id="tab-btn-roadmap" onclick="switchTab('roadmap')" class="flex-1 py-3 px-4 text-sm font-medium tab-inactive hover:text-white whitespace-nowrap transition-colors">Roadmap</button>
            <button id="tab-btn-colleges" onclick="switchTab('colleges')" class="flex-1 py-3 px-4 text-sm font-medium tab-inactive hover:text-white whitespace-nowrap transition-colors">Colleges</button>
        </div>

        <div class="p-5 space-y-6 pb-24">
            
            <div id="tab-content-overview" class="space-y-6">
                <div class="glass p-5 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-brand-400"></i> यह क्या है?
                    </h3>
                    <p id="detail-long-desc" class="text-sm text-slate-300 leading-relaxed">
                        Loading...
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-white mb-3">टॉप करियर विकल्प</h3>
                    <div id="detail-careers" class="grid grid-cols-2 gap-3">
                        </div>
                </div>

                <div class="glass p-5 rounded-2xl border border-green-500/30 bg-green-500/5">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-bold text-green-400 uppercase">औसत शुरुआती वेतन</h3>
                        <i class="fas fa-rupee-sign text-green-500"></i>
                    </div>
                    <div id="detail-salary" class="text-3xl font-black text-white">₹4 - ₹12 LPA</div>
                    <p class="text-[10px] text-slate-400 mt-1">* अनुभव और कॉलेज पर निर्भर करता है</p>
                </div>
            </div>

            <div id="tab-content-roadmap" class="hidden space-y-6">
                <div class="glass p-5 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-4">सफलता का नक्शा</h3>
                    <div id="detail-roadmap-steps" class="space-y-6 pl-2 border-l-2 border-slate-700 ml-2">
                        </div>
                </div>
            </div>

            <div id="tab-content-colleges" class="hidden space-y-4">
                <div class="glass p-4 rounded-xl text-center mb-4">
                    <i class="fas fa-university text-2xl text-yellow-400 mb-2"></i>
                    <h3 class="font-bold text-white">Top Institutes in India</h3>
                </div>
                <div id="detail-colleges" class="space-y-3">
                    </div>
            </div>

        </div>

        <div class="fixed bottom-0 left-0 right-0 p-4 bg-slate-900/90 backdrop-blur-xl border-t border-white/10 flex justify-center">
            <button class="w-full max-w-md bg-brand-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-brand-500/40 active:scale-95 transition-transform" onclick="alert('PDF Roadmap Download Started!')">
                <i class="fas fa-download mr-2"></i> Download Full Roadmap
            </button>
        </div>
    </div>

    <div id="counselor-modal" class="fixed inset-0 z-[60] bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-slate-900 w-full max-w-sm rounded-2xl border border-white/10 p-6 relative animate__animated animate__zoomIn">
            <button onclick="closeCounselorModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-brand-500/50">
                    <i class="fas fa-headset text-3xl text-brand-400"></i>
                </div>
                <h3 class="text-xl font-bold text-white">काउंसलर से बात करें</h3>
                <p class="text-sm text-slate-400 mt-2">अपना नंबर दें, हम आपको 24 घंटे में कॉल करेंगे।</p>
            </div>

            <form onsubmit="event.preventDefault(); submitCounselorForm();">
                <div class="space-y-4">
                    <input type="text" placeholder="आपका नाम" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-500 focus:outline-none placeholder-slate-500">
                    <input type="tel" placeholder="मोबाइल नंबर" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-500 focus:outline-none placeholder-slate-500">
                    <button type="submit" class="w-full bg-brand-600 py-3 rounded-xl font-bold text-white shadow-lg shadow-brand-500/30">
                        कॉल रिक्वेस्ट भेजें
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<div id="bottom-nav" class="fixed bottom-0 left-0 right-0 z-30 flex justify-center pb-safe">
    <div class="w-full max-w-md bg-slate-900/90 backdrop-blur-xl border-t border-white/10">
        <div class="flex justify-around items-center h-16">
            <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
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
    // --- 1. DATA SOURCE (Enhanced with Roadmap) ---
    const streamData = {
        'science_pcm': {
            name: 'Science (PCM)',
            category: 'Engineering & Tech',
            desc: 'For the innovators and problem solvers.',
            color: 'from-blue-600 to-blue-900',
            longDesc: 'PCM (Physics, Chemistry, Maths) सबसे लोकप्रिय स्ट्रीम है। यह उन छात्रों के लिए है जो मशीनों, सॉफ्टवेयर, निर्माण और गणितीय समस्याओं में रुचि रखते हैं।',
            salary: '₹6L - ₹18L',
            careers: [
                { title: 'Software Engg', icon: 'fa-laptop-code' },
                { title: 'Data Scientist', icon: 'fa-database' },
                { title: 'Civil Engg', icon: 'fa-building' },
                { title: 'Pilot', icon: 'fa-plane' }
            ],
            colleges: [
                'IIT Bombay (Indian Inst of Tech)',
                'NIT Trichy',
                'BITS Pilani',
                'Delhi Technological University'
            ],
            roadmap: [
                { title: 'Class 11-12', desc: 'Focus on PCM. Prepare for JEE Mains.' },
                { title: 'Entrance Exams', desc: 'Clear JEE Advanced / BITSAT / VITEEE.' },
                { title: 'Graduation (B.Tech)', desc: '4 Years Degree in CS/Mech/Civil.' },
                { title: 'Internships', desc: 'Gain practical experience in 3rd year.' },
                { title: 'Placement', desc: 'Land a job in Top Tech companies.' }
            ]
        },
        'science_pcb': {
            name: 'Science (PCB)',
            category: 'Medical & Biology',
            desc: 'For those who want to save lives.',
            color: 'from-brand-500 to-purple-900',
            longDesc: 'PCB (Physics, Chemistry, Biology) मेडिकल क्षेत्र का द्वार है। यदि आप डॉक्टर बनना चाहते हैं या जीव विज्ञान में रुचि रखते हैं, तो यह आपके लिए है।',
            salary: '₹8L - ₹25L',
            careers: [
                { title: 'Doctor (MBBS)', icon: 'fa-user-md' },
                { title: 'Dentist', icon: 'fa-tooth' },
                { title: 'Pharmacist', icon: 'fa-pills' },
                { title: 'Biotechnologist', icon: 'fa-dna' }
            ],
            colleges: [
                'AIIMS New Delhi',
                'CMC Vellore',
                'JIPMER Puducherry',
                'KGMU Lucknow'
            ],
            roadmap: [
                { title: 'Class 11-12', desc: 'Focus on PCB. Prepare for NEET.' },
                { title: 'Entrance Exam', desc: 'Crack NEET with high rank.' },
                { title: 'MBBS Degree', desc: '5.5 Years including internship.' },
                { title: 'Specialization (MD)', desc: '3 Years Master degree for expertise.' },
                { title: 'Practice', desc: 'Join Hospital or Private Practice.' }
            ]
        },
        'commerce': {
            name: 'Commerce',
            category: 'Business & Finance',
            desc: 'For the future CEOs and Bankers.',
            color: 'from-amber-500 to-orange-900',
            longDesc: 'Commerce स्ट्रीम व्यापार, वित्त और अर्थव्यवस्था की समझ विकसित करती है। यह CA, CS और मैनेजमेंट करियर के लिए बेस्ट है।',
            salary: '₹5L - ₹15L',
            careers: [
                { title: 'CA (Chartered Acc)', icon: 'fa-calculator' },
                { title: 'Investment Banker', icon: 'fa-chart-line' },
                { title: 'Company Sec (CS)', icon: 'fa-briefcase' },
                { title: 'Marketing Mgr', icon: 'fa-bullhorn' }
            ],
            colleges: [
                'SRCC Delhi',
                'St. Xaviers Mumbai',
                'Loyola College Chennai',
                'Christ University Bangalore'
            ],
            roadmap: [
                { title: 'Class 11-12', desc: 'Commerce with/without Maths.' },
                { title: 'Professional Course', desc: 'Register for CA Foundation or CLAT.' },
                { title: 'Graduation', desc: 'B.Com / BBA from top college.' },
                { title: 'Post Graduation', desc: 'MBA from IIMs (via CAT).' },
                { title: 'Corporate Job', desc: 'Leadership roles in MNCs.' }
            ]
        },
        'arts': {
            name: 'Arts / Humanities',
            category: 'Social Science & Creativity',
            desc: 'For leaders, thinkers and creators.',
            color: 'from-purple-500 to-indigo-900',
            longDesc: 'Arts स्ट्रीम सबसे बहुमुखी है। यह सिविल सेवा (IAS), कानून (Law), पत्रकारिता और डिजाइन जैसे क्षेत्रों के लिए आधार तैयार करती है।',
            salary: '₹4L - ₹20L',
            careers: [
                { title: 'IAS/IPS Officer', icon: 'fa-landmark' },
                { title: 'Lawyer', icon: 'fa-gavel' },
                { title: 'Journalist', icon: 'fa-newspaper' },
                { title: 'Graphic Designer', icon: 'fa-palette' }
            ],
            colleges: [
                'St. Stephens Delhi',
                'LSR College',
                'Hindu College',
                'NID (National Inst of Design)'
            ],
            roadmap: [
                { title: 'Class 11-12', desc: 'Humanities subjects.' },
                { title: 'Graduation', desc: 'BA in Pol Science/History/English.' },
                { title: 'Competitive Exam', desc: 'Prepare for UPSC CSE / CLAT.' },
                { title: 'Training', desc: 'LBSNAA or Law Firm Internship.' },
                { title: 'Service', desc: 'Serve the nation or society.' }
            ]
        }
    };

    // --- 2. FUNCTIONS ---

    function openStreamDetail(key) {
        const data = streamData[key];
        if(!data) return;

        // Reset Tab
        switchTab('overview');

        // Populate Basic Data
        document.getElementById('detail-title').innerText = data.name;
        document.getElementById('detail-name').innerText = data.name;
        document.getElementById('detail-category').innerText = data.category;
        document.getElementById('detail-desc').innerText = data.desc;
        document.getElementById('detail-long-desc').innerText = data.longDesc;
        document.getElementById('detail-salary').innerText = data.salary;
        
        // Update Hero Color
        document.getElementById('detail-hero-bg').className = `h-48 w-full bg-gradient-to-br ${data.color} relative p-6 flex flex-col justify-end`;

        // Render Careers (Overview Tab)
        const careersContainer = document.getElementById('detail-careers');
        careersContainer.innerHTML = '';
        data.careers.forEach(c => {
            careersContainer.innerHTML += `
                <div class="glass p-3 rounded-xl border border-white/5 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-brand-400">
                        <i class="fas ${c.icon}"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-200">${c.title}</span>
                </div>
            `;
        });

        // Render Colleges (Colleges Tab)
        const collegesContainer = document.getElementById('detail-colleges');
        collegesContainer.innerHTML = '';
        data.colleges.forEach((c, index) => {
            collegesContainer.innerHTML += `
                <div class="flex items-center justify-between p-3 bg-slate-800/50 rounded-xl border border-white/5">
                    <div class="flex items-center gap-3">
                        <span class="text-slate-500 font-bold text-sm">0${index + 1}</span>
                        <span class="text-sm text-white font-medium">${c}</span>
                    </div>
                    <i class="fas fa-trophy text-yellow-500 text-xs"></i>
                </div>
            `;
        });

        // Render Roadmap (Roadmap Tab) - NEW
        const roadmapContainer = document.getElementById('detail-roadmap-steps');
        roadmapContainer.innerHTML = '';
        if(data.roadmap) {
            data.roadmap.forEach((step, index) => {
                roadmapContainer.innerHTML += `
                    <div class="relative pl-6">
                        <div class="absolute left-[-5px] top-1 w-3 h-3 rounded-full bg-brand-500 border border-slate-900 shadow-[0_0_10px_#ec4899]"></div>
                        <h4 class="text-white font-bold text-sm">${step.title}</h4>
                        <p class="text-slate-400 text-xs mt-1">${step.desc}</p>
                    </div>
                `;
            });
        }

        // Show View
        document.getElementById('main-view').classList.remove('active-view');
        document.getElementById('main-view').classList.add('hidden-view');
        
        const detailView = document.getElementById('detail-view');
        detailView.classList.remove('hidden-view');
        detailView.classList.add('active-view');
        detailView.scrollTop = 0; // Reset scroll

        // Hide Bottom Nav
        document.getElementById('bottom-nav').style.display = 'none';
    }

    function closeStreamDetail() {
        document.getElementById('detail-view').classList.remove('active-view');
        document.getElementById('detail-view').classList.add('hidden-view');
        
        const mainView = document.getElementById('main-view');
        mainView.classList.remove('hidden-view');
        mainView.classList.add('active-view');

        // Show Bottom Nav
        document.getElementById('bottom-nav').style.display = 'flex';
    }

    // --- TAB SWITCHING LOGIC ---
    function switchTab(tabName) {
        // Hide all contents
        ['overview', 'roadmap', 'colleges'].forEach(t => {
            document.getElementById(`tab-content-${t}`).classList.add('hidden');
            const btn = document.getElementById(`tab-btn-${t}`);
            btn.classList.remove('tab-active', 'text-brand-400', 'border-b-2', 'border-brand-400', 'font-bold');
            btn.classList.add('tab-inactive', 'text-slate-400', 'font-medium');
        });

        // Show selected content
        document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
        
        // Active Button Style
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        activeBtn.classList.remove('tab-inactive', 'text-slate-400', 'font-medium');
        activeBtn.classList.add('tab-active', 'text-brand-400', 'border-b-2', 'border-brand-400', 'font-bold');
    }

    // Modal Logic
    function openCounselorModal() {
        document.getElementById('counselor-modal').classList.remove('hidden');
    }

    function closeCounselorModal() {
        document.getElementById('counselor-modal').classList.add('hidden');
    }

    function submitCounselorForm() {
        const btn = document.querySelector('#counselor-modal button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = 'Sending...';
        
        setTimeout(() => {
            btn.innerText = 'Sent Successfully!';
            btn.classList.add('bg-green-600');
            setTimeout(() => {
                closeCounselorModal();
                btn.innerText = originalText;
                btn.classList.remove('bg-green-600');
            }, 1000);
        }, 1500);
    }
</script>

@endsection