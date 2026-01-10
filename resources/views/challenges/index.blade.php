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
                    gold: { 400: '#facc15', 500: '#eab308' },
                    district: { 400: '#a78bfa', 500: '#8b5cf6' },
                    brain: { 400: '#2dd4bf', 500: '#14b8a6' }
                },
                animation: {
                    'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'shake': 'shake 0.5s cubic-bezier(.36,.07,.19,.97) both',
                },
                keyframes: {
                    shake: {
                        '10%, 90%': { transform: 'translate3d(-1px, 0, 0)' },
                        '20%, 80%': { transform: 'translate3d(2px, 0, 0)' },
                        '30%, 50%, 70%': { transform: 'translate3d(-4px, 0, 0)' },
                        '40%, 60%': { transform: 'translate3d(4px, 0, 0)' }
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

    .no-scrollbar::-webkit-scrollbar { display: none; }
    
    .tab-active { color: #ec4899; border-bottom: 2px solid #ec4899; }
    .tab-inactive { color: #94a3b8; border-bottom: 2px solid transparent; }

    /* Transitions */
    .view-section { transition: all 0.3s ease-in-out; }
    .hidden-view { display: none !important; opacity: 0; }
    .active-view { display: block !important; opacity: 1; animation: fadeIn 0.3s; }

    /* Game Styles */
    .option-btn { transition: all 0.1s; }
    .option-btn:active { transform: scale(0.95); }
    .correct-ans { background-color: #10b981 !important; border-color: #10b981 !important; color: white !important; }
    .wrong-ans { background-color: #ef4444 !important; border-color: #ef4444 !important; color: white !important; animation: shake 0.5s; }
</style>

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div id="view-hub" class="active-view w-full max-w-md mx-auto relative pt-20 px-0">
        
        <div class="fixed top-0 left-0 right-0 z-40 flex justify-center">
            <div class="w-full max-w-md h-16 bg-slate-900/95 border-b border-white/10 flex items-center justify-between px-4 backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="w-8 h-8 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <span class="font-bold text-lg tracking-wide">Challenge Arena</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-gold-500 flex items-center justify-center shadow-[0_0_10px_#eab308] text-black font-bold">
                    <i class="fas fa-trophy text-xs"></i>
                </div>
            </div>
        </div>

        <div class="flex border-b border-white/10 bg-slate-900/50 sticky top-16 z-30 px-2">
            <button onclick="switchTab('daily')" id="tab-btn-daily" class="flex-1 py-3 text-sm font-bold tab-active transition-colors">Daily Tasks</button>
            <button onclick="switchTab('mental')" id="tab-btn-mental" class="flex-1 py-3 text-sm font-medium tab-inactive hover:text-white transition-colors">Mental Gym</button>
            <button onclick="switchTab('district')" id="tab-btn-district" class="flex-1 py-3 text-sm font-medium tab-inactive hover:text-white transition-colors">District Cup</button>
        </div>

        <div class="p-4 min-h-[500px]">
            
            <div id="tab-daily" class="space-y-4">
                @php
                    $dailyTasks = [
                        ['id'=>1, 'title'=>'Focus Sprint', 'desc'=>'Study Physics for 25 mins without distraction.', 'xp'=>50, 'time'=>25, 'cat'=>'Study'],
                        ['id'=>2, 'title'=>'Hydration Check', 'desc'=>'Drink 2 glasses of water right now.', 'xp'=>20, 'time'=>2, 'cat'=>'Health'],
                        ['id'=>3, 'title'=>'Vocab Builder', 'desc'=>'Learn 5 new English words from newspaper.', 'xp'=>30, 'time'=>15, 'cat'=>'Skill']
                    ];
                @endphp

                @foreach($dailyTasks as $task)
                <div class="glass p-4 rounded-2xl border border-white/5 relative overflow-hidden group">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-brand-400 border border-white/10">
                                <i class="fas {{ $task['cat'] == 'Study' ? 'fa-book' : ($task['cat']=='Health'?'fa-tint':'fa-language') }}"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-sm">{{ $task['title'] }}</h3>
                                <p class="text-[10px] text-slate-400">{{ $task['time'] }} Mins • {{ $task['cat'] }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-gold-400 bg-gold-500/10 px-2 py-1 rounded-lg">+{{ $task['xp'] }} XP</span>
                    </div>
                    <p class="text-xs text-slate-300 mb-4">{{ $task['desc'] }}</p>
                    <button onclick="openDailyDetail('{{ $task['id'] }}', '{{ $task['title'] }}', '{{ $task['time'] }}')" class="w-full bg-slate-800 text-white py-2 rounded-xl text-xs font-bold border border-white/10 hover:bg-brand-600 hover:border-brand-500 transition-all">
                        Start Task
                    </button>
                </div>
                @endforeach
            </div>

            <div id="tab-mental" class="hidden space-y-4">
                <div class="flex justify-between items-center bg-slate-800/50 p-3 rounded-xl border border-white/5 mb-4">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-brain text-brain-400"></i>
                        <span class="text-xs text-slate-300">Brain Score: <strong class="text-white" id="brain-score">1250</strong></span>
                    </div>
                    <span class="text-[10px] bg-brain-500/10 text-brain-400 px-2 py-1 rounded">Rank: Top 10%</span>
                </div>

                <div class="glass p-4 rounded-2xl border border-brain-500/30 bg-brain-500/5 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-9xl text-brain-500/10 rotate-12"><i class="fas fa-calculator"></i></div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-white text-lg mt-1 mb-1">Rapid Math Sprint</h3>
                        <p class="text-xs text-slate-300 mb-3">Solve 5 arithmetic problems in 30s!</p>
                        <button onclick="GameEngine.startMathGame()" class="w-full bg-brain-600 text-white py-3 rounded-xl text-xs font-bold shadow-lg shadow-brain-500/30 hover:scale-[1.02] transition-transform">
                            <i class="fas fa-play mr-1"></i> Play Now
                        </button>
                    </div>
                </div>

                <div class="glass p-4 rounded-2xl border border-orange-500/30 bg-orange-500/5 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 text-9xl text-orange-500/10 rotate-12"><i class="fas fa-globe-asia"></i></div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-white text-lg mt-1 mb-1">India GK Blitz</h3>
                        <p class="text-xs text-slate-300 mb-3">Test your knowledge on History & Civics.</p>
                        <button onclick="GameEngine.startGKGame()" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl text-xs font-bold shadow-lg shadow-orange-500/30 hover:scale-[1.02] transition-transform">
                            <i class="fas fa-play mr-1"></i> Play Now
                        </button>
                    </div>
                </div>

                <div class="glass p-4 rounded-2xl border border-purple-500/30 bg-purple-500/5 relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold text-white text-lg mt-1 mb-1">Memory Matrix</h3>
                        <p class="text-xs text-slate-300 mb-3">Remember the pattern sequences.</p>
                        <button onclick="GameEngine.startMemoryGame()" class="w-full bg-purple-600 text-white py-3 rounded-xl text-xs font-bold shadow-lg shadow-purple-500/30">
                            <i class="fas fa-play mr-1"></i> Play Now
                        </button>
                    </div>
                </div>
            </div>

            <div id="tab-district" class="hidden space-y-4">
                <div class="bg-gradient-to-r from-district-500 to-indigo-600 p-5 rounded-2xl shadow-lg relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-3 opacity-20"><i class="fas fa-map-marked-alt text-6xl text-white"></i></div>
                    <h2 class="font-black text-white text-xl">District League</h2>
                    <p class="text-xs text-white/80">Varanasi Zone • Jan 2026</p>
                    <button onclick="openLeaderboard()" class="mt-3 bg-black/20 text-white text-xs px-3 py-1.5 rounded-lg font-bold border border-white/20 hover:bg-black/30">
                        View Full Leaderboard
                    </button>
                </div>

                <div class="glass p-4 rounded-2xl border-l-4 border-district-400">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="bg-district-500/20 text-district-300 text-[10px] px-2 py-0.5 rounded border border-district-500/30">Science</span>
                            <h3 class="font-bold text-white text-sm mt-1">Inter-School Science Quiz</h3>
                            <p class="text-[10px] text-slate-400">Organized by DM Office</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-green-400 block">Open</span>
                            <span class="text-[10px] text-slate-500">Ends in 2d</span>
                        </div>
                    </div>
                    <button onclick="openDistrictRegistration('Science Quiz')" class="w-full mt-3 bg-white text-slate-900 py-2 rounded-xl text-xs font-bold hover:bg-slate-200">Register Now</button>
                </div>
            </div>

        </div>
    </div>

    <div id="view-daily-detail" class="hidden-view w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space">
        <div class="p-6 h-full flex flex-col">
            <button onclick="goBack()" class="text-slate-400 hover:text-white mb-6 w-fit"><i class="fas fa-arrow-left text-2xl"></i></button>
            
            <div class="flex-1 flex flex-col items-center justify-center text-center">
                <div class="w-32 h-32 rounded-full border-4 border-brand-500 flex items-center justify-center mb-6 relative">
                    <div class="text-4xl font-black text-white" id="timer-display">25:00</div>
                    <div class="absolute -bottom-3 bg-brand-500 text-white text-xs px-2 py-1 rounded">Focus Mode</div>
                </div>
                
                <h2 class="text-2xl font-bold text-white mb-2" id="detail-title">Focus Sprint</h2>
                <p class="text-slate-400 text-sm mb-8">Keep your screen open. Do not switch apps.</p>
                
                <button onclick="completeTask()" class="w-full bg-brand-600 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-brand-500/40">
                    Mark as Completed
                </button>
            </div>
        </div>
    </div>

    <div id="view-district-reg" class="hidden-view w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space p-6">
        <button onclick="goBack()" class="text-slate-400 hover:text-white mb-4"><i class="fas fa-arrow-left text-xl"></i> Back</button>
        
        <h2 class="text-2xl font-bold text-white mb-1">Registration</h2>
        <p class="text-sm text-slate-400 mb-6">Event: <span id="reg-event-name" class="text-district-400 font-bold">Quiz</span></p>
        
        <form onsubmit="event.preventDefault(); submitReg();" class="space-y-4">
            <div>
                <label class="text-xs text-slate-400 block mb-1">Full Name</label>
                <input type="text" class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-white" value="{{ auth()->user()->profile->display_name ?? '' }}">
            </div>
            <div>
                <label class="text-xs text-slate-400 block mb-1">School / College Name</label>
                <input type="text" class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-white" placeholder="Enter School Name">
            </div>
            <div>
                <label class="text-xs text-slate-400 block mb-1">Class</label>
                <select class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-white">
                    <option>10th</option>
                    <option>12th</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-district-600 text-white py-3 rounded-xl font-bold mt-4 shadow-lg">Submit Application</button>
        </form>
    </div>

    <div id="view-create-challenge" class="hidden-view w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space p-6">
        <button onclick="goBack()" class="text-slate-400 hover:text-white mb-4"><i class="fas fa-arrow-left text-xl"></i> Cancel</button>
        <h2 class="text-2xl font-bold text-white mb-6">Challenge a Friend</h2>
        <div class="space-y-4">
            <input type="text" placeholder="Challenge Title (e.g. Read 10 Pages)" class="w-full bg-slate-800 border border-white/10 rounded-xl p-3 text-white">
            <div class="grid grid-cols-2 gap-3">
                <button class="bg-slate-800 border border-brand-500 text-brand-400 p-3 rounded-xl text-sm font-bold">1 Day</button>
                <button class="bg-slate-800 border border-white/10 text-slate-400 p-3 rounded-xl text-sm">3 Days</button>
            </div>
            <button onclick="submitCreate()" class="w-full bg-brand-600 text-white py-3 rounded-xl font-bold shadow-lg">Send Challenge</button>
        </div>
    </div>

    <div id="game-modal" class="fixed inset-0 z-[60] bg-slate-900 hidden flex-col">
        <div class="p-4 flex justify-between items-center border-b border-white/10">
            <button onclick="GameEngine.closeGame()" class="text-slate-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
            <div class="text-center">
                <h3 class="text-white font-bold" id="game-title">Game</h3>
                <span class="text-xs text-brand-400 font-mono" id="game-timer">00:30</span>
            </div>
            <div class="text-gold-400 font-bold text-sm" id="game-score">0 pts</div>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center p-6 relative">
            <div id="game-question-area" class="w-full text-center mb-8">
                <div class="text-sm text-slate-400 mb-2 uppercase tracking-wide">Question <span id="q-num">1</span>/5</div>
                <h1 class="text-3xl font-black text-white mb-2" id="q-text">Ready?</h1>
            </div>
            <div id="game-options-area" class="w-full grid grid-cols-2 gap-4 max-w-xs"></div>
            <div id="game-result-overlay" class="absolute inset-0 bg-slate-900/95 flex flex-col items-center justify-center hidden z-10">
                <i class="fas fa-trophy text-5xl text-gold-400 mb-4 animate-bounce"></i>
                <h2 class="text-2xl font-bold text-white mb-1">Game Over!</h2>
                <p class="text-slate-400 mb-6">Score: <span class="text-white font-bold text-xl" id="final-score">0</span></p>
                <button onclick="GameEngine.closeGame()" class="bg-brand-500 text-white px-8 py-3 rounded-xl font-bold">Continue</button>
            </div>
        </div>
    </div>

    <button onclick="openCreateChallenge()" class="fixed bottom-24 right-4 z-30 w-14 h-14 bg-brand-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-brand-500/40 active:scale-90 transition-transform">
        <i class="fas fa-plus text-xl"></i>
    </button>

</div>

<div class="fixed bottom-0 left-0 right-0 z-40 flex justify-center pb-safe">
    <div class="w-full max-w-md bg-slate-900/90 backdrop-blur-xl border-t border-white/10">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-home text-xl mb-1"></i><span class="text-[10px] font-medium">होम</span>
            </a>
            <a href="{{ route('education.index') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-graduation-cap text-xl mb-1"></i><span class="text-[10px] font-medium">कोर्स</span>
            </a>
            <div class="relative -top-5">
                <button class="w-14 h-14 rounded-full bg-gradient-to-tr from-brand-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/40 active:scale-90 transition-transform border-4 border-slate-900">
                    <i class="fas fa-plus text-xl"></i>
                </button>
            </div>
            <a href="{{ route('videos.index') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-video text-xl mb-1"></i><span class="text-[10px] font-medium">वीडियो</span>
            </a>
            <a href="{{ route('profile.show') }}" class="flex flex-col items-center justify-center w-full h-full text-slate-500 hover:text-slate-300">
                <i class="fas fa-user text-xl mb-1"></i><span class="text-[10px] font-medium">प्रोफाइल</span>
            </a>
        </div>
    </div>
</div>

<script>
    // --- NAVIGATION LOGIC ---
    function switchTab(tabId) {
        ['daily', 'mental', 'district'].forEach(id => {
            document.getElementById(`tab-${id}`).classList.add('hidden');
            const btn = document.getElementById(`tab-btn-${id}`);
            btn.classList.remove('tab-active', 'font-bold');
            btn.classList.add('tab-inactive', 'font-medium');
        });
        document.getElementById(`tab-${tabId}`).classList.remove('hidden');
        const activeBtn = document.getElementById(`tab-btn-${tabId}`);
        activeBtn.classList.remove('tab-inactive', 'font-medium');
        activeBtn.classList.add('tab-active', 'font-bold');
    }

    function toggleView(viewId, show) {
        const el = document.getElementById(viewId);
        const hub = document.getElementById('view-hub');
        if(show) {
            hub.classList.remove('active-view');
            hub.classList.add('hidden-view');
            el.classList.remove('hidden-view');
            el.classList.add('active-view');
        } else {
            el.classList.remove('active-view');
            el.classList.add('hidden-view');
            hub.classList.remove('hidden-view');
            hub.classList.add('active-view');
        }
    }

    function goBack() {
        // Hide all subviews, show hub
        ['view-daily-detail', 'view-district-reg', 'view-create-challenge'].forEach(id => {
            document.getElementById(id).classList.remove('active-view');
            document.getElementById(id).classList.add('hidden-view');
        });
        document.getElementById('view-hub').classList.remove('hidden-view');
        document.getElementById('view-hub').classList.add('active-view');
    }

    // --- DAILY CHALLENGES ---
    function openDailyDetail(id, title, time) {
        document.getElementById('detail-title').innerText = title;
        document.getElementById('timer-display').innerText = time + ":00";
        toggleView('view-daily-detail', true);
    }

    function completeTask() {
        alert("🎉 Task Completed! +50 XP");
        goBack();
    }

    // --- DISTRICT LOGIC ---
    function openDistrictRegistration(eventName) {
        document.getElementById('reg-event-name').innerText = eventName;
        toggleView('view-district-reg', true);
    }

    function submitReg() {
        alert("✅ Application Submitted! Check email for details.");
        goBack();
    }

    function openLeaderboard() {
        alert("🏆 Leaderboard:\n1. Rahul K. (980 pts)\n2. You (850 pts)\n3. Amit S. (820 pts)");
    }

    // --- CREATE CHALLENGE ---
    function openCreateChallenge() {
        toggleView('view-create-challenge', true);
    }

    function submitCreate() {
        alert("🚀 Challenge Sent to Friends!");
        goBack();
    }

    // --- GAME ENGINE (FULLY FUNCTIONAL) ---
    const GameEngine = {
        score: 0,
        currentQ: 0,
        timer: null,
        isPlaying: false,
        type: null,

        questions: [], // Holds current game questions

        gkDB: [
            { q: "Capital of India?", options: ["Mumbai", "Delhi", "Kolkata", "Chennai"], ans: 1 },
            { q: "Space Agency?", options: ["NASA", "ISRO", "ESA", "JAXA"], ans: 1 },
            { q: "National Bird?", options: ["Peacock", "Parrot", "Crow", "Eagle"], ans: 0 },
            { q: "Iron Man?", options: ["Gandhi", "Nehru", "Patel", "Bose"], ans: 2 }
        ],

        startMathGame() {
            this.setupGame('Rapid Math', 'math');
            this.nextMathQuestion();
        },

        startGKGame() {
            this.setupGame('GK Blitz', 'gk');
            this.questions = this.gkDB;
            this.nextGKQuestion();
        },

        startMemoryGame() {
            alert("Memory Matrix starting... (Simulated)");
            // Logic would go here
        },

        setupGame(title, type) {
            this.score = 0;
            this.currentQ = 0;
            this.type = type;
            this.isPlaying = true;
            document.getElementById('game-modal').classList.remove('hidden');
            document.getElementById('game-result-overlay').classList.add('hidden');
            document.getElementById('game-title').innerText = title;
            document.getElementById('game-score').innerText = '0 pts';
            
            let timeLeft = 30;
            const timerEl = document.getElementById('game-timer');
            clearInterval(this.timer);
            this.timer = setInterval(() => {
                timeLeft--;
                timerEl.innerText = `00:${timeLeft < 10 ? '0'+timeLeft : timeLeft}`;
                if(timeLeft <= 0) this.endGame();
            }, 1000);
        },

        nextMathQuestion() {
            if(this.currentQ >= 5) { this.endGame(); return; }
            this.currentQ++;
            document.getElementById('q-num').innerText = this.currentQ;

            const a = Math.floor(Math.random() * 20) + 1;
            const b = Math.floor(Math.random() * 20) + 1;
            const op = Math.random() > 0.5 ? '+' : '-';
            const correct = op === '+' ? a + b : a - b;
            
            document.getElementById('q-text').innerText = `${a} ${op} ${b} = ?`;
            let options = [correct, correct + 1, correct - 2, correct + 3].sort(() => Math.random() - 0.5);
            this.renderOptions(options, correct);
        },

        nextGKQuestion() {
            if(this.currentQ >= 4) { this.endGame(); return; }
            const qData = this.questions[this.currentQ];
            this.currentQ++;
            document.getElementById('q-num').innerText = this.currentQ;
            document.getElementById('q-text').innerText = qData.q;
            this.renderOptions(qData.options, qData.options[qData.ans]);
        },

        renderOptions(options, correct) {
            const area = document.getElementById('game-options-area');
            area.innerHTML = '';
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = "option-btn bg-slate-800 border border-white/10 text-white py-4 rounded-xl font-bold text-lg hover:bg-slate-700";
                btn.innerText = opt;
                btn.onclick = () => this.checkAnswer(btn, opt, correct);
                area.appendChild(btn);
            });
        },

        checkAnswer(btn, selected, correct) {
            if(!this.isPlaying) return;
            if(selected == correct) {
                btn.classList.add('correct-ans');
                this.score += 20;
                document.getElementById('game-score').innerText = this.score + ' pts';
            } else {
                btn.classList.add('wrong-ans');
            }
            this.isPlaying = false;
            setTimeout(() => {
                this.isPlaying = true;
                if(this.type === 'math') this.nextMathQuestion();
                else this.nextGKQuestion();
            }, 500);
        },

        endGame() {
            clearInterval(this.timer);
            this.isPlaying = false;
            document.getElementById('final-score').innerText = this.score + ' pts';
            document.getElementById('game-result-overlay').classList.remove('hidden');
        },

        closeGame() {
            clearInterval(this.timer);
            document.getElementById('game-modal').classList.add('hidden');
        }
    };
</script>

@endsection