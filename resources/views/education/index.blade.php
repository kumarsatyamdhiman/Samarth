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
                    edu: { 400: '#818cf8', 500: '#6366f1' }, // Indigo
                    safe: { 400: '#34d399', 500: '#10b981' }, // Emerald
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
    
    .view-transition { transition: opacity 0.3s ease, transform 0.3s ease; }
    .hidden-view { display: none !important; opacity: 0; pointer-events: none; }
    .active-view { display: block; opacity: 1; pointer-events: auto; }

    /* Form Elements */
    .form-input {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        padding: 12px;
        border-radius: 12px;
        width: 100%;
        outline: none;
        transition: border-color 0.3s;
    }
    .form-input:focus { border-color: #ec4899; }
    select.form-input { appearance: none; }
</style>

@php
    // Mock Profile Data (Can be dynamic from backend later)
    $profile = [ 'is_completed' => true, 'class' => '10th', 'stream' => 'Science (PCM)' ];
@endphp

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div id="main-view" class="w-full max-w-md mx-auto relative pt-20 px-4 active-view">

        <div class="fixed top-0 left-0 right-0 z-40 flex justify-center">
            <div class="w-full max-w-md h-16 bg-slate-900/95 border-b border-white/10 flex items-center justify-between px-4 backdrop-blur-md">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="w-8 h-8 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <span class="font-bold text-lg tracking-wide">Education Hub</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-edu-500 flex items-center justify-center shadow-[0_0_10px_#6366f1]">
                    <i class="fas fa-graduation-cap text-xs"></i>
                </div>
            </div>
        </div>

        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-edu-500 to-purple-600 rounded-full flex items-center justify-center mb-4 shadow-lg shadow-purple-500/30 animate-float">
                <i class="fas fa-compass text-3xl text-white"></i>
            </div>
            <h1 class="text-2xl font-black mb-2 text-white">शिक्षा मार्गदर्शन</h1>
            <p class="text-slate-400 text-sm leading-relaxed">
                सही रास्ता चुनें, भविष्य संवारें। <br>Stream, Career और College की पूरी जानकारी।
            </p>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-8 animate__animated animate__fadeInUp">
            <a href="{{ route('education.streams') }}" class="glass p-4 rounded-2xl border border-white/5 hover:border-brand-500/50 group active:scale-95 transition-all">
                <div class="w-10 h-10 rounded-xl bg-brand-500/10 flex items-center justify-center mb-3 text-brand-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-route text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-sm mb-1">स्ट्रीम चुनें</h3>
                <p class="text-[10px] text-slate-400">Science, Commerce, Arts</p>
            </a>

            <a href="{{ route('education.sectors') }}" class="glass p-4 rounded-2xl border border-white/5 hover:border-edu-500/50 group active:scale-95 transition-all">
                <div class="w-10 h-10 rounded-xl bg-edu-500/10 flex items-center justify-center mb-3 text-edu-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-industry text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-sm mb-1">सेक्टर एक्सप्लोर</h3>
                <p class="text-[10px] text-slate-400">Engineering, Medical, Law</p>
            </a>

            <a href="{{ route('education.exams') }}" class="glass p-4 rounded-2xl border border-white/5 hover:border-yellow-500/50 group active:scale-95 transition-all">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center mb-3 text-yellow-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-sm mb-1">परीक्षा प्लानर</h3>
                <p class="text-[10px] text-slate-400">JEE, NEET, CUET Dates</p>
            </a>

            <a href="{{ route('education.profile') }}" class="glass p-4 rounded-2xl border border-white/5 hover:border-green-500/50 group active:scale-95 transition-all">
                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center mb-3 text-green-400 group-hover:scale-110 transition-transform">
                    <i class="fas fa-user-cog text-xl"></i>
                </div>
                <h3 class="font-bold text-white text-sm mb-1">सेटिंग्स</h3>
                <p class="text-[10px] text-slate-400">Profile & Preferences</p>
            </a>
        </div>

        <div id="dashboard-plan-card" class="mb-8 cursor-pointer active:scale-95 transition-transform" onclick="checkAndOpenPlan()">
            <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4 px-1">
                <i class="fas fa-tasks mr-2 text-brand-400"></i> आपकी प्रगति
            </h2>
            
            <div class="glass p-4 rounded-2xl border border-white/10 hover:border-brand-500/30 transition-colors relative overflow-hidden">
                <div id="plan-state-empty" class="text-center py-2">
                    <div class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3 text-brand-400 animate-pulse">
                        <i class="fas fa-plus text-xl"></i>
                    </div>
                    <h3 class="font-bold text-white">Create Study Plan</h3>
                    <p class="text-xs text-slate-400 mt-1">Get a personalized 30-day roadmap</p>
                </div>

                <div id="plan-state-active" class="hidden">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h3 class="font-bold text-white text-sm">30-Day Mission</h3>
                            <p class="text-[10px] text-slate-400 mt-0.5" id="dash-day-display">Day 1</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-black text-brand-400" id="dash-progress-display">0%</span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-800 rounded-full h-2 mb-4 overflow-hidden">
                        <div id="dash-progress-bar" class="bg-gradient-to-r from-brand-600 to-brand-400 h-2 rounded-full relative" style="width: 0%"></div>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-800/50 p-3 rounded-xl border border-white/5">
                        <div class="w-8 h-8 rounded-full border-2 border-brand-500 flex items-center justify-center shrink-0">
                            <i class="fas fa-play text-[10px] text-brand-400 ml-0.5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Today's Goal</p>
                            <p class="text-xs text-white font-medium truncate" id="dash-task-display">Loading...</p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-500 ml-auto text-xs"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4 px-1">
                <i class="fas fa-book-open mr-2 text-edu-400"></i> संसाधन (Resources)
            </h2>
            <div class="flex overflow-x-auto space-x-3 no-scrollbar pb-2">
                <a href="https://swayam.gov.in" target="_blank" class="min-w-[140px] glass p-3 rounded-xl border border-white/5 text-center hover:border-brand-500/50 active:scale-95 transition-all">
                    <div class="w-10 h-10 mx-auto bg-slate-800 rounded-lg flex items-center justify-center mb-2 text-brand-400">
                        <i class="fas fa-video"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">Swayam</h4>
                    <p class="text-[10px] text-slate-400">Video Lectures</p>
                </a>
                
                <a href="https://ndl.iitkgp.ac.in" target="_blank" class="min-w-[140px] glass p-3 rounded-xl border border-white/5 text-center hover:border-blue-500/50 active:scale-95 transition-all">
                    <div class="w-10 h-10 mx-auto bg-slate-800 rounded-lg flex items-center justify-center mb-2 text-blue-400">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4 class="text-xs font-bold text-white">NDL India</h4>
                    <p class="text-[10px] text-slate-400">Digital Library</p>
                </a>
            </div>
        </div>

    </div>

    <div id="setup-view" class="w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space overflow-y-auto hidden-view">
        <div class="min-h-screen flex flex-col justify-center p-6">
            <button onclick="closeSetup()" class="absolute top-6 left-6 text-slate-400 hover:text-white">
                <i class="fas fa-arrow-left text-2xl"></i>
            </button>

            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-brand-500/20 rounded-full flex items-center justify-center mx-auto mb-4 text-brand-400 border border-brand-500/50">
                    <i class="fas fa-magic text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">Create Your Plan</h2>
                <p class="text-sm text-slate-400 mt-2">Personalize your 30-day journey.</p>
            </div>

            <form onsubmit="event.preventDefault(); generatePlan();" class="space-y-5">
                <div>
                    <label class="text-sm font-bold text-slate-300 mb-2 block">Select Class</label>
                    <select id="setup-class" class="form-input" onchange="updateStreams()">
                        <option value="9">Class 9</option>
                        <option value="10">Class 10</option>
                        <option value="11">Class 11</option>
                        <option value="12">Class 12</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-bold text-slate-300 mb-2 block">Select Stream/Subject</label>
                    <select id="setup-stream" class="form-input">
                        </select>
                </div>

                <div>
                    <label class="text-sm font-bold text-slate-300 mb-2 block">Daily Study Hours</label>
                    <input type="range" id="setup-hours" min="1" max="8" value="3" class="w-full accent-brand-500 h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-xs text-slate-400 mt-1">
                        <span>1 Hr</span>
                        <span id="hours-display" class="text-brand-400 font-bold">3 Hours</span>
                        <span>8 Hrs</span>
                    </div>
                </div>

                <button type="submit" id="generate-btn" class="w-full bg-gradient-to-r from-brand-600 to-purple-600 py-4 rounded-xl font-bold text-white shadow-lg shadow-brand-500/30 mt-4 flex items-center justify-center gap-2">
                    <i class="fas fa-wand-magic-sparkles"></i> Generate Roadmap
                </button>
            </form>
        </div>
    </div>

    <div id="plan-view" class="w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space overflow-y-auto hidden-view">
        
        <div class="sticky top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-xl border-b border-white/10 p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button onclick="closePlan()" class="w-10 h-10 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-white active:scale-90 transition-transform">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div>
                    <h2 class="font-bold text-lg text-white leading-none">My Roadmap</h2>
                    <span class="text-[10px] text-brand-400 font-medium" id="plan-header-stream">Science</span>
                </div>
            </div>
            <button onclick="resetPlan()" class="text-xs text-red-400 hover:text-red-300 bg-red-900/20 px-3 py-1 rounded-lg border border-red-500/20">
                <i class="fas fa-trash mr-1"></i> Reset
            </button>
        </div>

        <div class="p-5 pb-24">
            <div class="text-center mb-8 mt-2">
                <div class="inline-block relative">
                    <svg class="w-32 h-32 transform -rotate-90">
                        <circle cx="64" cy="64" r="56" stroke="#1e293b" stroke-width="8" fill="none" />
                        <circle id="ring-progress" cx="64" cy="64" r="56" stroke="#ec4899" stroke-width="8" fill="none" stroke-dasharray="351" stroke-dashoffset="351" stroke-linecap="round" class="transition-all duration-1000" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-black text-white" id="plan-total-percent">0%</span>
                        <span class="text-[10px] text-slate-400 uppercase">Completed</span>
                    </div>
                </div>
                <p class="text-sm text-slate-300 mt-4 px-4 italic">
                    "Success is the sum of small efforts, repeated day-in and day-out."
                </p>
            </div>

            <h3 class="text-sm font-bold text-brand-400 uppercase tracking-wider mb-4">Today's Focus</h3>
            <div class="glass p-5 rounded-2xl border border-brand-500/50 mb-8 bg-brand-500/5 relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-brand-500 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg" id="today-day-num">Day 1</div>
                <div class="flex items-start gap-4">
                    <div class="mt-1">
                        <button onclick="toggleToday()" id="today-check-btn" class="w-6 h-6 rounded-full border-2 border-brand-500 flex items-center justify-center text-transparent hover:bg-brand-500/20 transition-all">
                            <i class="fas fa-check text-xs"></i>
                        </button>
                    </div>
                    <div>
                        <h4 class="text-white font-bold text-lg" id="today-subject">Subject</h4>
                        <p class="text-sm text-slate-300 mt-1" id="today-topic">Topic Name</p>
                        <div class="flex gap-2 mt-3">
                            <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-white border border-white/10" id="today-hours">2 Hours</span>
                            <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-white border border-white/10">Priority</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Upcoming Schedule</h3>
            <div class="space-y-0 pl-4 border-l-2 border-slate-800 ml-2" id="plan-timeline-container">
                </div>
        </div>
    </div>

</div>

<div id="bottom-nav" class="fixed bottom-0 left-0 right-0 z-30 flex justify-center pb-safe">
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
    // --- 1. SYLLABUS DATABASE (RELEVANT CHAPTERS) ---
    const syllabusDB = {
        '9': {
            'general': {
                subjects: ['Maths', 'Science', 'Social Science', 'English'],
                chapters: {
                    'Maths': ['Number Systems', 'Polynomials', 'Coordinate Geometry', 'Linear Equations', 'Lines and Angles', 'Triangles', 'Heron’s Formula', 'Surface Areas', 'Statistics', 'Probability'],
                    'Science': ['Matter in Our Surroundings', 'Is Matter Around Us Pure', 'Atoms and Molecules', 'The Fundamental Unit of Life', 'Tissues', 'Motion', 'Force and Laws of Motion', 'Gravitation', 'Work and Energy', 'Sound'],
                    'Social Science': ['French Revolution', 'Socialism in Europe', 'Nazism', 'Forest Society', 'Democracy', 'Constitutional Design', 'Electoral Politics', 'India - Size and Location', 'Physical Features of India'],
                    'English': ['The Fun They Had', 'Sound of Music', 'The Little Girl', 'A Truly Beautiful Mind', 'The Snake and the Mirror', 'My Childhood', 'Reach for the Top', 'Kathmandu']
                }
            }
        },
        '10': {
            'general': {
                subjects: ['Maths', 'Science', 'Social Science', 'English'],
                chapters: {
                    'Maths': ['Real Numbers', 'Polynomials', 'Linear Equations', 'Quadratic Equations', 'Arithmetic Progressions', 'Triangles', 'Coordinate Geometry', 'Trigonometry', 'Circles', 'Constructions', 'Statistics'],
                    'Science': ['Chemical Reactions', 'Acids, Bases and Salts', 'Metals and Non-Metals', 'Carbon and its Compounds', 'Life Processes', 'Control and Coordination', 'How do Organisms Reproduce', 'Heredity', 'Light', 'Human Eye', 'Electricity'],
                    'Social Science': ['Rise of Nationalism in Europe', 'Nationalism in India', 'Making of a Global World', 'Age of Industrialisation', 'Resources and Development', 'Agriculture', 'Manufacturing Industries', 'Power Sharing', 'Federalism'],
                    'English': ['A Letter to God', 'Nelson Mandela', 'Two Stories about Flying', 'From the Diary of Anne Frank', 'The Hundred Dresses', 'Glimpses of India', 'Madam Rides the Bus']
                }
            }
        },
        '11': {
            'science_pcm': {
                subjects: ['Physics', 'Chemistry', 'Maths'],
                chapters: {
                    'Physics': ['Units and Measurement', 'Motion in a Straight Line', 'Motion in a Plane', 'Laws of Motion', 'Work, Energy and Power', 'Rotational Motion', 'Gravitation', 'Solids', 'Fluids', 'Thermodynamics'],
                    'Chemistry': ['Some Basic Concepts', 'Structure of Atom', 'Periodicity', 'Chemical Bonding', 'Thermodynamics', 'Equilibrium', 'Redox Reactions', 'Organic Chemistry Basics', 'Hydrocarbons'],
                    'Maths': ['Sets', 'Relations and Functions', 'Trigonometric Functions', 'Complex Numbers', 'Linear Inequalities', 'Permutations and Combinations', 'Binomial Theorem', 'Sequence and Series', 'Straight Lines']
                }
            },
            'science_pcb': {
                subjects: ['Physics', 'Chemistry', 'Biology'],
                chapters: {
                    'Physics': ['Units and Measurement', 'Motion in a Straight Line', 'Motion in a Plane', 'Laws of Motion', 'Work, Energy and Power', 'Rotational Motion', 'Gravitation', 'Solids', 'Fluids'],
                    'Chemistry': ['Some Basic Concepts', 'Structure of Atom', 'Periodicity', 'Chemical Bonding', 'Thermodynamics', 'Equilibrium', 'Redox Reactions', 'Organic Chemistry Basics', 'Hydrocarbons'],
                    'Biology': ['The Living World', 'Biological Classification', 'Plant Kingdom', 'Animal Kingdom', 'Morphology of Flowering Plants', 'Anatomy of Flowering Plants', 'Cell: The Unit of Life', 'Biomolecules', 'Cell Cycle']
                }
            },
            'commerce': {
                subjects: ['Accountancy', 'Business Studies', 'Economics'],
                chapters: {
                    'Accountancy': ['Introduction to Accounting', 'Theory Base', 'Recording of Transactions', 'Bank Reconciliation', 'Ledger', 'Trial Balance', 'Depreciation', 'Bills of Exchange'],
                    'Business Studies': ['Nature and Purpose of Business', 'Forms of Business Organisation', 'Public, Private Enterprises', 'Business Services', 'Emerging Modes of Business', 'Social Responsibility'],
                    'Economics': ['Introduction', 'Collection of Data', 'Organisation of Data', 'Presentation of Data', 'Measures of Central Tendency', 'Correlation', 'Index Numbers', 'Indian Economy on Eve of Independence']
                }
            },
            'arts': {
                subjects: ['History', 'Political Science', 'Geography'],
                chapters: {
                    'History': ['Writing and City Life', 'An Empire Across Three Continents', 'Nomadic Empires', 'The Three Orders', 'Changing Cultural Traditions', 'Displacing Indigenous Peoples', 'Paths to Modernisation'],
                    'Political Science': ['Constitution: Why and How', 'Rights in the Indian Constitution', 'Election and Representation', 'Executive', 'Legislature', 'Judiciary', 'Federalism', 'Local Governments'],
                    'Geography': ['Geography as a Discipline', 'The Origin and Evolution of the Earth', 'Interior of the Earth', 'Distribution of Oceans and Continents', 'Minerals and Rocks', 'Geomorphic Processes', 'Landforms']
                }
            }
        },
        '12': {
            'science_pcm': {
                subjects: ['Physics', 'Chemistry', 'Maths'],
                chapters: {
                    'Physics': ['Electric Charges and Fields', 'Potential and Capacitance', 'Current Electricity', 'Moving Charges and Magnetism', 'Magnetism and Matter', 'EMI', 'Alternating Current', 'EM Waves', 'Ray Optics', 'Wave Optics'],
                    'Chemistry': ['Solutions', 'Electrochemistry', 'Chemical Kinetics', 'd and f Block Elements', 'Coordination Compounds', 'Haloalkanes', 'Alcohols, Phenols and Ethers', 'Aldehydes, Ketones', 'Amines'],
                    'Maths': ['Relations and Functions', 'Inverse Trig', 'Matrices', 'Determinants', 'Continuity and Differentiability', 'Application of Derivatives', 'Integrals', 'Application of Integrals', 'Differential Equations', 'Vectors', '3D Geometry']
                }
            },
            'science_pcb': {
                subjects: ['Physics', 'Chemistry', 'Biology'],
                chapters: {
                    'Physics': ['Electric Charges and Fields', 'Potential and Capacitance', 'Current Electricity', 'Moving Charges and Magnetism', 'Magnetism and Matter', 'EMI', 'Alternating Current', 'EM Waves', 'Ray Optics'],
                    'Chemistry': ['Solutions', 'Electrochemistry', 'Chemical Kinetics', 'd and f Block Elements', 'Coordination Compounds', 'Haloalkanes', 'Alcohols, Phenols and Ethers', 'Aldehydes, Ketones', 'Amines'],
                    'Biology': ['Reproduction in Organisms', 'Sexual Reproduction in Plants', 'Human Reproduction', 'Reproductive Health', 'Principles of Inheritance', 'Molecular Basis of Inheritance', 'Evolution', 'Human Health and Disease']
                }
            },
            'commerce': {
                subjects: ['Accountancy', 'Business Studies', 'Economics'],
                chapters: {
                    'Accountancy': ['NPO', 'Partnership: Basic Concepts', 'Reconstitution of Partnership', 'Dissolution', 'Share Capital', 'Debentures', 'Financial Statements', 'Ratio Analysis', 'Cash Flow'],
                    'Business Studies': ['Nature of Management', 'Principles of Management', 'Business Environment', 'Planning', 'Organising', 'Staffing', 'Directing', 'Controlling', 'Financial Management'],
                    'Economics': ['National Income', 'Money and Banking', 'Determination of Income', 'Government Budget', 'Balance of Payments', 'Indian Economy 1950-1990', 'Liberalisation', 'Poverty', 'Human Capital']
                }
            },
            'arts': {
                subjects: ['History', 'Political Science', 'Geography'],
                chapters: {
                    'History': ['Bricks, Beads and Bones', 'Kings, Farmers and Towns', 'Kinship, Caste and Class', 'Thinkers, Beliefs and Buildings', 'Through the Eyes of Travellers', 'Bhakti-Sufi Traditions', 'An Imperial Capital: Vijayanagara'],
                    'Political Science': ['The Cold War Era', 'The End of Bipolarity', 'US Hegemony', 'Alternative Centres of Power', 'Contemporary South Asia', 'International Organisations', 'Security in Contemporary World'],
                    'Geography': ['Human Geography', 'The World Population', 'Population Composition', 'Human Development', 'Primary Activities', 'Secondary Activities', 'Tertiary and Quaternary Activities', 'Transport and Communication']
                }
            }
        }
    };

    const STORAGE_KEY = 'samarth_study_plan_v2';

    // --- 2. INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        // Init Setup Listeners
        const classSelect = document.getElementById('setup-class');
        const hourSlider = document.getElementById('setup-hours');
        
        if(classSelect) {
            classSelect.addEventListener('change', updateStreams);
            updateStreams(); // Run once on load
        }
        
        if(hourSlider) {
            hourSlider.addEventListener('input', function() {
                document.getElementById('hours-display').innerText = this.value + ' Hours';
            });
        }
        
        loadDashboardState();
    });

    // --- 3. DYNAMIC FORM LOGIC ---
    function updateStreams() {
        const cls = document.getElementById('setup-class').value;
        const streamSelect = document.getElementById('setup-stream');
        streamSelect.innerHTML = ''; // Clear existing

        let options = [];
        if (cls === '9' || cls === '10') {
            options = [{val: 'general', text: 'General (All Subjects)'}];
        } else {
            options = [
                {val: 'science_pcm', text: 'Science (PCM)'},
                {val: 'science_pcb', text: 'Science (PCB)'},
                {val: 'commerce', text: 'Commerce'},
                {val: 'arts', text: 'Arts / Humanities'}
            ];
        }

        options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.val;
            option.text = opt.text;
            streamSelect.add(option);
        });
    }

    // --- 4. PLAN GENERATION (THE BRAIN) ---
    function generatePlan() {
        const btn = document.getElementById('generate-btn');
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Analyzing Syllabus...';
        
        const cls = document.getElementById('setup-class').value;
        const stream = document.getElementById('setup-stream').value;
        const hours = document.getElementById('setup-hours').value;
        
        setTimeout(() => {
            // Get relevant syllabus
            const syllabus = syllabusDB[cls][stream];
            if (!syllabus) {
                alert('Syllabus not found for this combination.');
                btn.innerHTML = 'Generate Plan';
                return;
            }

            const tasks = [];
            const subjects = syllabus.subjects;
            // Track chapter index for each subject
            const chapterTracker = {}; 
            subjects.forEach(sub => chapterTracker[sub] = 0);

            // Generate 30 days
            for(let i=1; i<=30; i++) {
                // Rotate subjects: Day 1->Subj1, Day 2->Subj2, etc.
                const subjIndex = (i - 1) % subjects.length;
                const currentSubject = subjects[subjIndex];
                
                // Get chapter
                const chapterList = syllabus.chapters[currentSubject];
                let chapterName = "Revision / Mock Test"; // Fallback
                
                if (chapterTracker[currentSubject] < chapterList.length) {
                    chapterName = chapterList[chapterTracker[currentSubject]];
                    chapterTracker[currentSubject]++; // Move to next chapter
                }

                tasks.push({
                    day: i,
                    subject: currentSubject,
                    topic: chapterName,
                    completed: false
                });
            }

            const newPlan = {
                class: cls,
                stream: stream,
                hours: hours,
                tasks: tasks,
                createdAt: new Date().getTime()
            };

            localStorage.setItem(STORAGE_KEY, JSON.stringify(newPlan));
            
            btn.innerHTML = 'Generate Plan';
            closeSetup();
            openPlanView();
        }, 1500);
    }

    // --- 5. VIEW MANAGEMENT ---
    function checkAndOpenPlan() {
        const savedPlan = localStorage.getItem(STORAGE_KEY);
        if (savedPlan) {
            openPlanView();
        } else {
            openSetupView();
        }
    }

    function openSetupView() {
        switchView('setup-view');
        document.getElementById('bottom-nav').style.display = 'none';
    }

    function closeSetup() {
        switchView('main-view');
        document.getElementById('bottom-nav').style.display = 'flex';
    }

    function openPlanView() {
        renderPlan();
        switchView('plan-view');
        document.getElementById('bottom-nav').style.display = 'none';
    }

    function closePlan() {
        loadDashboardState();
        switchView('main-view');
        document.getElementById('bottom-nav').style.display = 'flex';
    }

    function switchView(viewId) {
        ['main-view', 'setup-view', 'plan-view'].forEach(id => {
            const el = document.getElementById(id);
            if(id === viewId) {
                el.classList.remove('hidden-view');
                el.classList.add('active-view');
                el.scrollTop = 0;
            } else {
                el.classList.remove('active-view');
                el.classList.add('hidden-view');
            }
        });
    }

    function resetPlan() {
        if(confirm("Delete current plan?")) {
            localStorage.removeItem(STORAGE_KEY);
            closePlan();
            loadDashboardState();
        }
    }

    // --- 6. RENDER LOGIC ---
    function renderPlan() {
        const plan = JSON.parse(localStorage.getItem(STORAGE_KEY));
        if(!plan) return;

        // Stream Text in Header
        const streamNames = { 'science_pcm':'Science PCM', 'science_pcb':'Science PCB', 'commerce':'Commerce', 'arts':'Arts', 'general':'Class '+plan.class };
        document.getElementById('plan-header-stream').innerText = streamNames[plan.stream] || plan.stream;

        // Progress Math
        const total = plan.tasks.length;
        const completed = plan.tasks.filter(t => t.completed).length;
        const percentage = Math.round((completed / total) * 100);
        
        // Find Today (First incomplete)
        let todayTask = plan.tasks.find(t => !t.completed);
        // If all done, show last task
        if(!todayTask) todayTask = plan.tasks[plan.tasks.length - 1]; 

        // Update Ring
        const offset = 351 - (351 * percentage / 100);
        document.getElementById('ring-progress').style.strokeDashoffset = offset;
        document.getElementById('plan-total-percent').innerText = percentage + '%';

        // Update Today Card
        document.getElementById('today-day-num').innerText = 'Day ' + todayTask.day;
        document.getElementById('today-subject').innerText = todayTask.subject;
        document.getElementById('today-topic').innerText = todayTask.topic;
        document.getElementById('today-hours').innerText = plan.hours + ' Hours';
        
        // Toggle Button Visuals
        const btn = document.getElementById('today-check-btn');
        if(todayTask.completed) {
            btn.innerHTML = '<i class="fas fa-check text-white"></i>';
            btn.className = "w-6 h-6 rounded-full border-2 border-brand-500 flex items-center justify-center bg-brand-500 transition-all";
        } else {
            btn.innerHTML = '<i class="fas fa-check text-xs"></i>';
            btn.className = "w-6 h-6 rounded-full border-2 border-brand-500 flex items-center justify-center text-transparent hover:bg-brand-500/20 transition-all";
        }
        btn.onclick = () => toggleTask(todayTask.day);

        // Upcoming Timeline
        const container = document.getElementById('plan-timeline-container');
        container.innerHTML = '';
        
        const upcoming = plan.tasks.filter(t => t.day > todayTask.day).slice(0, 5);
        if(upcoming.length === 0 && percentage === 100) {
            container.innerHTML = '<div class="text-green-400 text-center text-sm font-bold">🎉 Plan Completed!</div>';
        }

        upcoming.forEach(t => {
            container.innerHTML += `
                <div class="relative pl-6 pb-6 border-l-2 border-slate-700 last:border-0">
                    <div class="absolute left-[-9px] top-0 w-4 h-4 rounded-full bg-slate-800 border-2 border-slate-600"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] text-slate-500 font-bold uppercase">Day ${t.day}</span>
                            <h4 class="text-white font-bold text-sm">${t.subject}</h4>
                            <p class="text-xs text-slate-400">${t.topic}</p>
                        </div>
                        <i class="fas fa-lock text-slate-600 text-xs"></i>
                    </div>
                </div>
            `;
        });
    }

    function toggleTask(day) {
        const plan = JSON.parse(localStorage.getItem(STORAGE_KEY));
        const idx = plan.tasks.findIndex(t => t.day === day);
        if(idx > -1) {
            plan.tasks[idx].completed = !plan.tasks[idx].completed;
            localStorage.setItem(STORAGE_KEY, JSON.stringify(plan));
            renderPlan();
        }
    }

    function toggleToday() {
        // Wrapper for the button click
        // Logic handled inside renderPlan mapping
    }

    function loadDashboardState() {
        const plan = JSON.parse(localStorage.getItem(STORAGE_KEY));
        const emptyState = document.getElementById('plan-state-empty');
        const activeState = document.getElementById('plan-state-active');

        if(plan) {
            emptyState.classList.add('hidden');
            activeState.classList.remove('hidden');

            const completed = plan.tasks.filter(t => t.completed).length;
            const percentage = Math.round((completed / 30) * 100);
            
            // Active task
            let todayTask = plan.tasks.find(t => !t.completed);
            if(!todayTask) todayTask = plan.tasks[29];

            document.getElementById('dash-day-display').innerText = 'Day ' + todayTask.day;
            document.getElementById('dash-progress-display').innerText = percentage + '%';
            document.getElementById('dash-progress-bar').style.width = percentage + '%';
            document.getElementById('dash-task-display').innerText = `${todayTask.subject}: ${todayTask.topic}`;
        } else {
            emptyState.classList.remove('hidden');
            activeState.classList.add('hidden');
        }
    }
</script>

@endsection