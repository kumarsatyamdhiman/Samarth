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
                    gov: { 500: '#f59e0b', 600: '#d97706' }
                },
                animation: {
                    'blob': 'blob 10s infinite',
                    'float': 'float 3s ease-in-out infinite',
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'scan': 'scan 2s linear infinite',
                },
                keyframes: {
                    blob: {
                        '0%': { transform: 'translate(0px, 0px) scale(1)' },
                        '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                        '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                        '100%': { transform: 'translate(0px, 0px) scale(1)' },
                    },
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-10px)' },
                    },
                    scan: {
                        '0%': { top: '0%' },
                        '100%': { top: '100%' },
                    }
                }
            }
        }
    }
</script>

<style>
    body { background-color: #0f172a; color: white; -webkit-tap-highlight-color: transparent; font-family: 'Noto Sans Devanagari', sans-serif; }
    
    /* Background Image */
    .bg-space {
        background-image: url('https://images.unsplash.com/photo-1534796636912-3b95b3ab5986?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
        background-size: cover;
        background-position: center;
        background-blend-mode: overlay;
    }

    /* Glassmorphism */
    .glass {
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Utilities */
    .neon-text { text-shadow: 0 0 15px rgba(219, 39, 119, 0.6); }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    
    /* ALIGNMENT FIX: Ticker */
    .ticker-wrap { 
        flex: 1; /* This prevents the ticker from pushing off screen */
        overflow: hidden; 
        white-space: nowrap; 
        min-width: 0; 
    }
    .ticker { display: inline-block; padding-left: 100%; animation: ticker 30s linear infinite; }
    @keyframes ticker { 0% { transform: translate3d(0, 0, 0); } 100% { transform: translate3d(-100%, 0, 0); } }
    
    /* Quiz Styles */
    .scanner-line { position: absolute; width: 100%; height: 2px; background: #ec4899; box-shadow: 0 0 10px #ec4899; animation: scan 1.5s ease-in-out infinite alternate; }
    .option-card:active { transform: scale(0.98); background: rgba(236, 72, 153, 0.2); border-color: #ec4899; }
    .timeline-line { position: absolute; left: 24px; top: 20px; bottom: 0; width: 2px; background: rgba(255,255,255,0.1); z-index: 0; }
</style>

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div id="dashboard-section" class="w-full max-w-md mx-auto relative min-h-screen shadow-2xl">
        
        <div class="fixed top-0 left-0 right-0 z-50 flex justify-center">
            <div class="w-full max-w-md h-10 bg-slate-900/95 border-b border-white/10 flex items-center backdrop-blur-md">
                <div class="bg-brand-600 h-full px-3 flex items-center justify-center font-bold text-xs uppercase z-10 shadow-lg shrink-0">
                    <span class="animate-pulse mr-1 text-white">●</span> लाइव
                </div>
                <div class="ticker-wrap flex items-center h-full">
                    <div class="ticker text-sm font-medium text-slate-200" id="newsTicker">
                        </div>
                </div>
            </div>
        </div>

        <div class="relative pt-24 px-4 pb-10 text-center overflow-hidden">
            <div class="absolute top-20 left-10 w-48 h-48 bg-purple-600 rounded-full mix-blend-screen filter blur-[80px] opacity-40 animate-blob"></div>
            <div class="absolute top-40 right-10 w-48 h-48 bg-brand-500 rounded-full mix-blend-screen filter blur-[80px] opacity-40 animate-blob animation-delay-2000"></div>

            <div class="relative inline-block mb-6 animate-float">
                <div class="absolute -inset-1 bg-gradient-to-r from-brand-500 to-purple-600 rounded-full blur opacity-75"></div>
                <div class="relative w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center border-2 border-white/20 shadow-2xl">
                    <span class="text-5xl">🚀</span>
                </div>
            </div>

            <h1 class="text-4xl font-black mb-3 leading-tight">
                <span class="block text-white">अपना सपना</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-purple-400 to-brand-400 neon-text">सच करें!</span>
            </h1>
            
            <p class="text-slate-400 text-sm mb-8 px-4 leading-relaxed">
                <span class="text-brand-400 font-bold">50,000+</span> छात्रों ने यहाँ से शुरुआत की। <br>IAS, डॉक्टर, इंजीनियर बनने का सही रास्ता।
            </p>

            <div class="grid grid-cols-3 gap-2 mb-8">
                <div class="glass p-3 rounded-xl text-center">
                    <div class="text-xl font-black text-brand-400" id="counter1">0</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">छात्र</div>
                </div>
                <div class="glass p-3 rounded-xl text-center">
                    <div class="text-xl font-black text-purple-400" id="counter2">0</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">लक्ष्य</div>
                </div>
                <div class="glass p-3 rounded-xl text-center">
                    <div class="text-xl font-black text-green-400">92%</div>
                    <div class="text-[10px] text-slate-500 font-bold uppercase">सफलता</div>
                </div>
            </div>

            <div class="space-y-3">
                <button onclick="openQuiz()" class="w-full relative group overflow-hidden bg-gradient-to-r from-brand-600 to-purple-600 p-4 rounded-xl font-bold text-lg shadow-lg shadow-brand-500/30 active:scale-95 transition-transform">
                    <div class="absolute inset-0 bg-white/20 group-hover:translate-x-full transition-transform duration-500 ease-out -translate-x-full skew-x-12"></div>
                    <span class="relative flex items-center justify-center gap-2">
                        🎯 अपना लक्ष्य चुनें <i class="fas fa-arrow-right text-sm"></i>
                    </span>
                </button>
                
                <button onclick="openQuiz()" class="w-full block glass p-4 rounded-xl font-bold text-slate-200 active:bg-white/10 transition-colors border border-white/10">
                    <i class="fas fa-brain text-purple-400 mr-2"></i> 5 मिनट करियर टेस्ट
                </button>
            </div>
        </div>

        <div class="px-4 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-fire text-orange-500 animate-pulse"></i> ट्रेंडिंग करियर
                </h2>
                <span class="text-[10px] bg-green-500/20 text-green-400 px-2 py-1 rounded-full animate-pulse">LIVE DATA</span>
            </div>
            <div class="flex overflow-x-auto space-x-4 no-scrollbar pb-4" id="careerContainer">
                </div>
        </div>

        <div class="px-4 space-y-6">
            <div class="glass rounded-2xl p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-2 opacity-20"><i class="fas fa-bolt text-6xl text-yellow-400"></i></div>
                <h3 class="text-lg font-bold mb-4">अभी-अभी हुआ</h3>
                <div class="space-y-4 max-h-[200px] overflow-hidden relative" id="activityFeed">
                    </div>
                <div class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-slate-900/90 to-transparent pointer-events-none"></div>
            </div>

            <div class="glass rounded-2xl p-5">
                <h3 class="text-lg font-bold mb-4 text-slate-200"><i class="fas fa-hourglass-half text-brand-400 mr-2"></i> परीक्षा काउंटडाउन</h3>
                <div class="space-y-3" id="examList">
                    </div>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 z-40 flex justify-center pb-safe">
            <div class="w-full max-w-md bg-slate-900/90 backdrop-blur-xl border-t border-white/10">
                <div class="flex justify-around items-center h-16">
                    <a href="#" class="flex flex-col items-center justify-center w-full h-full text-brand-500">
                        <i class="fas fa-home text-xl mb-1"></i><span class="text-[10px] font-medium">होम</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                        <i class="fas fa-graduation-cap text-xl mb-1"></i><span class="text-[10px] font-medium">कोर्स</span>
                    </a>
                    <div class="relative -top-5">
                        <button onclick="openQuiz()" class="w-14 h-14 rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/40 active:scale-90 transition-transform border-4 border-slate-900">
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
    </div>

    <div id="quiz-section" class="hidden fixed inset-0 z-50 bg-slate-900 bg-space overflow-y-auto">
        <div class="fixed top-0 left-0 w-full p-4 z-50 flex justify-between items-center max-w-md mx-auto left-0 right-0">
            <button class="w-10 h-10 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform" onclick="closeQuiz()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Samarth AI</div>
        </div>

        <div class="w-full max-w-md mx-auto relative min-h-screen flex flex-col justify-center py-12 px-4">
            <div class="text-center animate__animated animate__fadeIn" id="screen-intro">
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <div class="absolute inset-0 bg-brand-500 rounded-full blur-2xl opacity-40 animate-pulse-slow"></div>
                    <div class="relative w-full h-full glass rounded-full flex items-center justify-center border-2 border-brand-500/50">
                        <i class="fas fa-brain text-5xl text-transparent bg-clip-text bg-gradient-to-tr from-brand-400 to-purple-400"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-black mb-3">
                    <span class="text-white">AI करियर</span> <span class="text-brand-400">प्रेडिक्टर</span>
                </h1>
                <p class="text-slate-300 text-sm mb-8 px-4 leading-relaxed">
                    हमारा AI आपकी रुचियों को स्कैन करके बताएगा कि आप भविष्य में <strong class="text-white">CEO, डॉक्टर, या इंजीनियर</strong> क्या बनने वाले हैं!
                </p>
                <button class="w-full bg-gradient-to-r from-brand-600 to-purple-600 p-4 rounded-2xl font-bold text-lg shadow-lg shadow-brand-500/40 relative overflow-hidden group" onclick="startTest()">
                    <span class="relative z-10 flex items-center justify-center gap-2">🚀 टेस्ट शुरू करें (फ्री)</span>
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </button>
            </div>

            <div class="hidden w-full" id="screen-quiz">
                <div class="mb-6">
                    <div class="flex justify-between text-xs font-bold text-brand-400 mb-2">
                        <span id="q-counter">प्रश्न 1/4</span>
                        <span>विश्लेषण जारी...</span>
                    </div>
                    <div class="h-2 w-full bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-brand-500 to-purple-500 w-[20%] progress-bar shadow-[0_0_10px_#ec4899]" id="progress-bar"></div>
                    </div>
                </div>
                <div class="glass p-6 rounded-3xl border border-white/10 relative overflow-hidden min-h-[300px] flex flex-col justify-center">
                    <h2 class="text-xl font-bold text-white mb-6 leading-snug animate__animated animate__fadeIn" id="question-text">Loading...</h2>
                    <div class="space-y-3" id="options-container"></div>
                </div>
            </div>

            <div class="hidden text-center w-full" id="screen-loading">
                <div class="glass p-8 rounded-3xl relative overflow-hidden mx-4">
                    <div class="scanner-line top-0 left-0"></div>
                    <i class="fas fa-fingerprint text-6xl text-slate-600 mb-4 animate-pulse"></i>
                    <h3 class="text-xl font-bold text-white mb-2">AI डेटा स्कैन कर रहा है...</h3>
                    <p class="text-xs text-brand-400 font-mono" id="loading-text">रुचियों का मिलान हो रहा है...</p>
                </div>
            </div>

            <div class="hidden w-full animate__animated animate__zoomIn" id="screen-result">
                <div class="relative glass rounded-[2rem] p-6 border border-brand-500/30 overflow-hidden text-center">
                    <div class="absolute top-0 right-0 bg-brand-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl text-white">98% मैच</div>
                    <div class="w-24 h-24 mx-auto bg-slate-900 rounded-full flex items-center justify-center border-4 border-brand-500 shadow-[0_0_30px_rgba(236,72,153,0.4)] mb-4 relative z-10">
                        <i class="fas fa-user-astronaut text-4xl text-white" id="result-icon"></i>
                    </div>
                    <h2 class="text-sm text-slate-400 uppercase tracking-widest mb-1">आप बने हैं</h2>
                    <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-400 mb-4" id="result-title">फ्यूचर CEO</h1>
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5">
                            <div class="text-[10px] text-slate-400">अनुमानित वेतन</div>
                            <div class="text-sm font-bold text-green-400" id="result-salary">₹25L - ₹1Cr</div>
                        </div>
                        <div class="bg-slate-900/50 p-3 rounded-xl border border-white/5">
                            <div class="text-[10px] text-slate-400">डिमांड</div>
                            <div class="text-sm font-bold text-brand-400">🔥 बहुत ज्यादा</div>
                        </div>
                    </div>
                    <p class="text-sm text-slate-300 mb-6 leading-relaxed" id="result-desc"></p>
                    <button class="w-full bg-white text-slate-900 font-bold py-4 rounded-xl mb-3 hover:bg-slate-100 shadow-lg flex items-center justify-center gap-2 animate-pulse" onclick="showRoadmap()">
                        <i class="fas fa-map-signs text-brand-600"></i> मेरा रोडमैप देखें
                    </button>
                </div>
            </div>

            <div class="hidden w-full animate__animated animate__fadeInUp" id="screen-roadmap">
                <div class="glass rounded-[2rem] p-6 border border-white/10 relative min-h-[600px]">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h2 class="text-xs text-brand-400 font-bold uppercase tracking-wider">आपका रास्ता</h2>
                            <h1 class="text-2xl font-black text-white" id="roadmap-title">डॉक्टर कैसे बनें?</h1>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center border border-white/10" onclick="hideRoadmap()">
                            <i class="fas fa-times text-slate-400"></i>
                        </div>
                    </div>
                    <div class="relative pl-2 space-y-8 mb-10" id="roadmap-steps"></div>
                    <div class="bg-slate-900/80 rounded-2xl p-5 border border-gov-600/30 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 text-gov-600/10 text-9xl"><i class="fas fa-landmark"></i></div>
                        <h3 class="text-gov-500 font-bold mb-4 flex items-center gap-2 relative z-10"><i class="fas fa-check-circle"></i> सरकारी संसाधन</h3>
                        <div class="space-y-3 relative z-10" id="roadmap-gov-links"></div>
                    </div>
                    <button class="w-full mt-6 bg-slate-800 text-slate-300 py-3 rounded-xl text-sm font-bold border border-white/10" onclick="alert('रोडमैप डाउनलोड हो रहा है...')">
                        <i class="fas fa-download mr-2"></i> सेव करें (PDF)
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<canvas id="confetti-canvas" class="fixed inset-0 pointer-events-none z-[100]"></canvas>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    // --- DASHBOARD DATA ---
    const appData = {
        news: [
            "📢 UPSC 2024 परिणाम घोषित - अभी चेक करें!", "🚀 इसरो ने छात्रों के लिए इंटर्नशिप शुरू की", 
            "💻 भारत में AI नौकरियों में 40% वेतन वृद्धि", "🏥 NEET काउंसलिंग का दूसरा राउंड कल से शुरू", 
            "👮 SSC CGL अधिसूचना: 15,000+ रिक्तियां"
        ],
        careers: [
            { title: "सॉफ्टवेयर इंजीनियर", salary: "₹12-25 लाख", icon: "fas fa-laptop-code", color: "text-blue-400", border: "border-blue-500" },
            { title: "डॉक्टर (MBBS)", salary: "₹15-30 लाख", icon: "fas fa-user-md", color: "text-green-400", border: "border-green-500" },
            { title: "डिजिटल मार्केटर", salary: "₹5-12 लाख", icon: "fas fa-hashtag", color: "text-pink-400", border: "border-pink-500" },
            { title: "डाटा साइंटिस्ट", salary: "₹18-35 लाख", icon: "fas fa-database", color: "text-purple-400", border: "border-purple-500" },
            { title: "चार्टर्ड अकाउंटेंट", salary: "₹8-20 लाख", icon: "fas fa-calculator", color: "text-yellow-400", border: "border-yellow-500" }
        ],
        exams: [
            { name: "JEE मेन्स 2025", date: "2025-01-24" },
            { name: "NEET UG 2025", date: "2025-05-05" },
            { name: "UPSC प्रीलिम्स", date: "2025-06-16" }
        ],
        activities: [
            { name: "राहुल", action: "ने डॉक्टर बनने का लक्ष्य चुना", color: "bg-blue-500" },
            { name: "प्रिया", action: "ने करियर टेस्ट पूरा किया", color: "bg-green-500" },
            { name: "अमित", action: "ने 'AI का भविष्य' वीडियो देखा", color: "bg-purple-500" },
            { name: "स्नेहा", action: "ने गोल्ड बैज जीता", color: "bg-orange-500" }
        ]
    };

    // --- QUIZ DATA ---
    const questions = [
        {
            q: "आप खाली समय में क्या करना पसंद करते हैं?",
            options: [
                { text: "गैजेट्स खोलना और ठीक करना", type: "tech" },
                { text: "दोस्तों की समस्याएं सुलझाना", type: "social" },
                { text: "पेंटिंग या लेखन करना", type: "creative" },
                { text: "पैसे कमाना और बिजनेस सोचना", type: "business" }
            ]
        },
        {
            q: "स्कूल में आपका पसंदीदा विषय कौन सा है?",
            options: [
                { text: "गणित या कंप्यूटर", type: "tech" },
                { text: "बायोलॉजी या विज्ञान", type: "medical" },
                { text: "इतिहास या राजनीति", type: "admin" },
                { text: "कोई भी नहीं, मुझे स्पोर्ट्स पसंद है", type: "active" }
            ]
        },
        {
            q: "अगर आपको सुपरपावर मिले, तो आप क्या चुनेंगे?",
            options: [
                { text: "दिमाग पढ़ने की शक्ति", type: "business" },
                { text: "बीमारी ठीक करना", type: "medical" },
                { text: "दुनिया का सबसे स्मार्ट इंसान", type: "tech" },
                { text: "लोगों को हंसाना/मनोरंजन", type: "creative" }
            ]
        },
        {
            q: "आप किस तरह के माहौल में काम करना चाहेंगे?",
            options: [
                { text: "शांत AC ऑफिस में लैपटॉप पर", type: "tech" },
                { text: "हॉस्पिटल या लैब में", type: "medical" },
                { text: "स्टेज पर या स्टूडियो में", type: "creative" },
                { text: "मीटिंग्स और लीडरशिप में", type: "business" }
            ]
        }
    ];

    const results = {
        tech: { title: "टेक जीनियस / इंजीनियर", icon: "fas fa-laptop-code", salary: "₹12L - ₹45L", desc: "कोडिंग और इनोवेशन आपकी दुनिया है।" },
        medical: { title: "डॉक्टर / वैज्ञानिक", icon: "fas fa-user-md", salary: "₹15L - ₹60L", desc: "आप में सेवा भाव और विज्ञान के प्रति गहरा प्रेम है।" },
        creative: { title: "आर्टिस्ट / क्रिएटर", icon: "fas fa-palette", salary: "₹5L - ₹1Cr+", desc: "आपकी कल्पना शक्ति अद्भुत है।" },
        business: { title: "CEO / आंत्रप्रेन्योर", icon: "fas fa-briefcase", salary: "असीमित", desc: "आप रिस्क लेने से नहीं डरते और लीडर हैं।" },
        social: { title: "काउंसलर / टीचर", icon: "fas fa-hands-helping", salary: "₹4L - ₹15L", desc: "आप लोगों को समझते हैं और मदद करते हैं।" },
        admin: { title: "IAS / सिविल सर्वेंट", icon: "fas fa-landmark", salary: "₹8L - ₹25L + Power", desc: "आप देश को बदलना चाहते हैं।" },
        active: { title: "खिलाड़ी / डिफेंस", icon: "fas fa-running", salary: "₹6L - ₹50L", desc: "एक्शन और अनुशासन आपकी पहचान है।" }
    };

    const roadmapData = {
        tech: {
            title: "सॉफ्टवेयर इंजीनियर का रास्ता",
            steps: [
                { title: "10वीं के बाद", desc: "Science Stream (PCM) चुनें" },
                { title: "एंट्रेंस एग्जाम", desc: "JEE Mains & Advanced की तैयारी करें" },
                { title: "डिग्री", desc: "B.Tech/B.E (CS/IT Branch)" },
                { title: "स्किल्स", desc: "Coding (Python, Java), DSA सीखें" }
            ],
            govLinks: [
                { name: "SWAYAM (Free Courses)", url: "https://swayam.gov.in" },
                { name: "NPTEL (IIT Lectures)", url: "https://nptel.ac.in" },
                { name: "AICTE Internship", url: "https://internship.aicte-india.org" }
            ]
        },
        business: {
            title: "CEO / बिजनेसमैन का रास्ता",
            steps: [{ title: "12वीं कक्षा", desc: "Commerce/Any Stream" }, { title: "डिग्री", desc: "BBA / B.Com करें" }, { title: "मास्टर्स", desc: "MBA (CAT Exam)" }],
            govLinks: [{ name: "Startup India", url: "#" }, { name: "MUDRA Loan", url: "#" }]
        }
    };

    // --- LOGIC ---
    let currentQIndex = 0;
    let scores = {};
    let finalCareerType = 'tech';

    document.addEventListener('DOMContentLoaded', () => {
        initDashboard();
    });

    // --- NAVIGATION ---
    window.openQuiz = function() {
        document.getElementById('dashboard-section').classList.add('hidden');
        document.getElementById('quiz-section').classList.remove('hidden');
        currentQIndex = 0;
        scores = {};
        document.getElementById('screen-intro').classList.remove('hidden');
        document.getElementById('screen-quiz').classList.add('hidden');
        document.getElementById('screen-result').classList.add('hidden');
        document.getElementById('screen-roadmap').classList.add('hidden');
    }

    window.closeQuiz = function() {
        document.getElementById('quiz-section').classList.add('hidden');
        document.getElementById('dashboard-section').classList.remove('hidden');
    }

    // --- DASHBOARD FUNCTIONS ---
    function initDashboard() {
        const ticker = document.getElementById('newsTicker');
        let content = "";
        appData.news.forEach(item => content += `<span class="mx-4"><span class="text-brand-400 mr-2">➤</span>${item}</span>`);
        ticker.innerHTML = content + content;

        animateValue("counter1", 0, 50234, 2000);
        animateValue("counter2", 0, 89421, 2500);

        const cContainer = document.getElementById('careerContainer');
        appData.careers.forEach(c => {
            cContainer.innerHTML += `
                <div class="glass min-w-[200px] p-4 rounded-2xl border-l-4 ${c.border} flex-shrink-0 snap-center active:scale-95 transition-transform">
                    <div class="flex justify-between items-start mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center"><i class="${c.icon} ${c.color} text-xl"></i></div>
                        <span class="text-[10px] bg-white/10 px-2 py-1 rounded text-slate-300">High Growth</span>
                    </div>
                    <h3 class="font-bold text-white mb-1">${c.title}</h3>
                    <p class="text-xs text-slate-400">वेतन: <span class="text-slate-200 font-semibold">${c.salary}</span></p>
                </div>`;
        });

        const feed = document.getElementById('activityFeed');
        appData.activities.forEach(a => {
            feed.innerHTML += `
                <div class="flex items-center gap-3 p-2 rounded-lg animate__animated animate__fadeInLeft">
                    <div class="w-8 h-8 rounded-full ${a.color} flex items-center justify-center text-xs font-bold text-white shadow shadow-${a.color}/50">${a.name[0]}</div>
                    <div class="text-xs text-slate-300">
                        <span class="font-bold text-white">${a.name}</span> ${a.action}
                        <span class="block text-[10px] text-slate-500">अभी-अभी</span>
                    </div>
                </div>`;
        });

        const examList = document.getElementById('examList');
        appData.exams.forEach(e => {
            const diff = Math.ceil((new Date(e.date) - new Date()) / (1000 * 60 * 60 * 24));
            examList.innerHTML += `
                <div class="flex items-center justify-between border-b border-white/5 pb-2 last:border-0">
                    <div><div class="font-bold text-sm text-white">${e.name}</div><div class="text-[10px] text-slate-400">${e.date}</div></div>
                    <div class="text-right"><span class="text-lg font-black text-brand-400">${diff}</span><span class="text-[10px] text-slate-500 block">दिन शेष</span></div>
                </div>`;
        });
    }

    function animateValue(id, start, end, duration) {
        let obj = document.getElementById(id);
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString('en-IN');
            if (progress < 1) window.requestAnimationFrame(step);
        };
        window.requestAnimationFrame(step);
    }

    // --- QUIZ FUNCTIONS ---
    window.startTest = function() {
        document.getElementById('screen-intro').classList.add('hidden');
        document.getElementById('screen-quiz').classList.remove('hidden');
        renderQuestion();
    }

    function renderQuestion() {
        const q = questions[currentQIndex];
        document.getElementById('question-text').innerText = q.q;
        document.getElementById('q-counter').innerText = `प्रश्न ${currentQIndex + 1}/${questions.length}`;
        document.getElementById('progress-bar').style.width = `${((currentQIndex + 1) / questions.length) * 100}%`;
        
        const container = document.getElementById('options-container');
        container.innerHTML = '';
        q.options.forEach((opt, idx) => {
            const btn = document.createElement('button');
            btn.className = "option-card w-full text-left p-4 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 text-slate-200 transition-all duration-200 flex items-center gap-3 animate__animated animate__fadeInUp";
            btn.style.animationDelay = `${idx * 100}ms`;
            btn.innerHTML = `<div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-xs text-brand-400 font-bold border border-white/10">${String.fromCharCode(65 + idx)}</div><span class="font-medium">${opt.text}</span>`;
            btn.onclick = () => selectAnswer(opt.type);
            container.appendChild(btn);
        });
    }

    function selectAnswer(type) {
        scores[type] = (scores[type] || 0) + 1;
        if (currentQIndex < questions.length - 1) {
            currentQIndex++;
            renderQuestion();
        } else {
            finishQuiz();
        }
    }

    function finishQuiz() {
        document.getElementById('screen-quiz').classList.add('hidden');
        document.getElementById('screen-loading').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('screen-loading').classList.add('hidden');
            calculateResult();
            showResult();
        }, 2500);
    }

    function calculateResult() {
        finalCareerType = Object.keys(scores).reduce((a, b) => scores[a] > scores[b] ? a : b, 'business');
    }

    function showResult() {
        const data = results[finalCareerType] || results['business'];
        document.getElementById('result-title').innerText = data.title;
        document.getElementById('result-icon').className = `${data.icon} text-4xl text-white`;
        document.getElementById('result-salary').innerText = data.salary;
        document.getElementById('result-desc').innerText = data.desc;
        document.getElementById('screen-result').classList.remove('hidden');
        fireConfetti();
    }

    window.showRoadmap = function() {
        document.getElementById('screen-result').classList.add('hidden');
        document.getElementById('screen-roadmap').classList.remove('hidden');
        const data = roadmapData[finalCareerType] || roadmapData['business'];
        document.getElementById('roadmap-title').innerText = data.title;
        
        const stepsContainer = document.getElementById('roadmap-steps');
        stepsContainer.innerHTML = `<div class="timeline-line"></div>`;
        data.steps.forEach((step, index) => {
            stepsContainer.innerHTML += `
                <div class="timeline-item flex gap-4 animate__animated animate__fadeInRight" style="animation-delay: ${index * 200}ms">
                    <div class="w-12 h-12 rounded-full bg-slate-900 border-2 border-brand-500 flex items-center justify-center text-brand-400 font-bold shadow-[0_0_15px_#ec4899] shrink-0 z-10">${index + 1}</div>
                    <div class="bg-white/5 border border-white/10 p-4 rounded-xl w-full">
                        <h4 class="text-white font-bold mb-1">${step.title}</h4>
                        <p class="text-slate-400 text-sm">${step.desc}</p>
                    </div>
                </div>`;
        });

        const govContainer = document.getElementById('roadmap-gov-links');
        govContainer.innerHTML = '';
        data.govLinks.forEach(link => {
            govContainer.innerHTML += `
                <a href="${link.url}" target="_blank" class="flex items-center justify-between p-3 bg-slate-800/50 rounded-lg border border-gov-600/20 hover:bg-gov-600/20 transition-colors group">
                    <span class="text-sm font-medium text-slate-200">${link.name}</span>
                    <i class="fas fa-external-link-alt text-gov-500 group-hover:text-white"></i>
                </a>`;
        });
    }

    window.hideRoadmap = function() {
        document.getElementById('screen-roadmap').classList.add('hidden');
        document.getElementById('screen-result').classList.remove('hidden');
    }

    function fireConfetti() {
        const canvas = document.getElementById('confetti-canvas');
        const myConfetti = confetti.create(canvas, { resize: true });
        myConfetti({ particleCount: 100, spread: 70, origin: { y: 0.6 }, colors: ['#ec4899', '#a855f7', '#ffffff'] });
    }
</script>

@endsection