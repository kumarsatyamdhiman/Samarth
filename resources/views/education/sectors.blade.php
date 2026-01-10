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
                    tech: { 400: '#38bdf8', 500: '#0ea5e9' },
                    med: { 400: '#f87171', 500: '#ef4444' },
                    biz: { 400: '#fbbf24', 500: '#f59e0b' },
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
    
    /* View Transitions */
    .view-transition { transition: opacity 0.3s ease, transform 0.3s ease; }
    .hidden-view { display: none; opacity: 0; pointer-events: none; }
    .active-view { display: block; opacity: 1; pointer-events: auto; }

    /* Tabs */
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
                    <span class="font-bold text-lg tracking-wide">Career Sectors</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-brand-600 flex items-center justify-center shadow-[0_0_10px_#ec4899]">
                    <i class="fas fa-industry text-xs"></i>
                </div>
            </div>
        </div>

        <div class="text-center mb-8 animate__animated animate__fadeInDown">
            <h1 class="text-3xl font-black mb-2 leading-tight">
                <span class="block text-white">अपना भविष्य</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-purple-500 neon-text">
                    चुनें!
                </span>
            </h1>
            <p class="text-slate-400 text-sm">
                टॉप करियर सेक्टर्स और कोर्सेस की <br>पूरी जानकारी यहाँ पाएं।
            </p>
        </div>

        <div class="mb-6 relative">
            <input type="text" id="sector-search" placeholder="Search sectors (e.g. Engineering)..." 
                   class="w-full bg-slate-800 border border-white/10 rounded-xl px-10 py-3 text-white focus:border-brand-500 focus:outline-none placeholder-slate-500"
                   onkeyup="filterSectors()">
            <i class="fas fa-search absolute left-4 top-3.5 text-slate-500"></i>
        </div>

        <div id="sectors-grid" class="grid grid-cols-2 gap-3 pb-20">
            </div>

    </div>

    <div id="detail-view" class="w-full max-w-md mx-auto fixed inset-0 z-50 bg-slate-900 bg-space overflow-y-auto hidden-view">
        
        <div class="sticky top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-xl border-b border-white/10 p-4 flex items-center gap-4">
            <button onclick="closeDetail()" class="w-10 h-10 rounded-full bg-slate-800 border border-white/10 flex items-center justify-center text-white active:scale-90 transition-transform">
                <i class="fas fa-arrow-left"></i>
            </button>
            <h2 id="detail-title" class="font-bold text-lg text-white">Sector Details</h2>
        </div>

        <div id="detail-hero-bg" class="h-48 w-full bg-gradient-to-br from-blue-600 to-slate-900 relative p-6 flex flex-col justify-end">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-2">
                    <span id="detail-growth" class="text-[10px] bg-green-500 text-white px-2 py-0.5 rounded-full font-bold">High Growth</span>
                </div>
                <h1 id="detail-name" class="text-3xl font-black text-white mb-1">Engineering</h1>
                <p id="detail-desc" class="text-sm text-slate-200">Building the future.</p>
            </div>
        </div>

        <div class="flex border-b border-white/10 bg-slate-900/90 sticky top-16 z-40 overflow-x-auto no-scrollbar">
            <button id="tab-btn-overview" onclick="switchTab('overview')" class="flex-1 py-3 px-4 text-sm font-bold tab-active whitespace-nowrap transition-colors">Overview</button>
            <button id="tab-btn-courses" onclick="switchTab('courses')" class="flex-1 py-3 px-4 text-sm font-medium tab-inactive hover:text-white whitespace-nowrap transition-colors">Courses</button>
            <button id="tab-btn-exams" onclick="switchTab('exams')" class="flex-1 py-3 px-4 text-sm font-medium tab-inactive hover:text-white whitespace-nowrap transition-colors">Exams</button>
        </div>

        <div class="p-5 space-y-6 pb-24">
            
            <div id="tab-content-overview" class="space-y-6 animate__animated animate__fadeIn">
                <div class="glass p-5 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-brand-400"></i> क्यों चुनें?
                    </h3>
                    <p id="detail-why" class="text-sm text-slate-300 leading-relaxed">
                        Loading...
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-white mb-3">करियर के अवसर</h3>
                    <div id="detail-careers" class="grid grid-cols-2 gap-3">
                        </div>
                </div>

                <div class="glass p-5 rounded-2xl border border-green-500/30 bg-green-500/5">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-bold text-green-400">औसत वेतन (Salary)</h3>
                        <i class="fas fa-rupee-sign text-green-500"></i>
                    </div>
                    <div id="detail-salary" class="text-3xl font-black text-white">₹5L - ₹20L</div>
                </div>
            </div>

            <div id="tab-content-courses" class="hidden space-y-4 animate__animated animate__fadeIn">
                <h3 class="text-lg font-bold text-white">प्रमुख कोर्स</h3>
                <div id="detail-courses-list" class="space-y-3">
                    </div>
            </div>

            <div id="tab-content-exams" class="hidden space-y-4 animate__animated animate__fadeIn">
                <h3 class="text-lg font-bold text-white">प्रवेश परीक्षाएं (Entrance Exams)</h3>
                <div id="detail-exams-list" class="space-y-3">
                    </div>
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
    // --- 1. SECTOR DATA ---
    const sectors = [
        {
            id: 'engg',
            name: 'Engineering',
            icon: 'fa-microchip',
            color: 'tech',
            bg: 'from-blue-600 to-cyan-800',
            desc: 'Innovation & Technology',
            why: 'टेक्नोलॉजी और विकास का मुख्य आधार है। सॉफ्टवेयर, सिविल, मैकेनिकल जैसे क्षेत्रों में असीमित अवसर हैं।',
            salary: '₹4L - ₹25L',
            careers: ['Software Dev', 'Data Scientist', 'Civil Engineer', 'Robotics Engg'],
            courses: [
                { name: 'B.Tech (CSE)', duration: '4 Years', type: 'Degree' },
                { name: 'B.Tech (Mech)', duration: '4 Years', type: 'Degree' },
                { name: 'BCA', duration: '3 Years', type: 'Degree' },
                { name: 'Polytechnic', duration: '3 Years', type: 'Diploma' }
            ],
            exams: [
                { name: 'JEE Mains', date: 'Jan/Apr' },
                { name: 'JEE Advanced', date: 'May' },
                { name: 'BITSAT', date: 'June' },
                { name: 'VITEEE', date: 'April' }
            ]
        },
        {
            id: 'med',
            name: 'Medical',
            icon: 'fa-user-md',
            color: 'med',
            bg: 'from-red-600 to-pink-900',
            desc: 'Healthcare & Research',
            why: 'समाज सेवा और विज्ञान का बेहतरीन संगम। डॉक्टर, नर्स और रिसर्चर्स की हमेशा मांग रहती है।',
            salary: '₹6L - ₹30L',
            careers: ['Doctor (MBBS)', 'Dentist', 'Nurse', 'Pharmacist'],
            courses: [
                { name: 'MBBS', duration: '5.5 Years', type: 'Degree' },
                { name: 'BDS (Dental)', duration: '5 Years', type: 'Degree' },
                { name: 'B.Pharma', duration: '4 Years', type: 'Degree' },
                { name: 'B.Sc Nursing', duration: '4 Years', type: 'Degree' }
            ],
            exams: [
                { name: 'NEET UG', date: 'May' },
                { name: 'AIIMS Nursing', date: 'June' },
                { name: 'NEET PG', date: 'Jan' }
            ]
        },
        {
            id: 'law',
            name: 'Law',
            icon: 'fa-gavel',
            color: 'brand',
            bg: 'from-purple-600 to-indigo-900',
            desc: 'Justice & Corporate Law',
            why: 'न्याय और कॉर्पोरेट जगत में करियर। वकालत और जज बनने के अवसर।',
            salary: '₹5L - ₹20L',
            careers: ['Lawyer', 'Judge', 'Legal Advisor', 'Public Prosecutor'],
            courses: [
                { name: 'BA LLB', duration: '5 Years', type: 'Integrated' },
                { name: 'LLB', duration: '3 Years', type: 'Degree' },
                { name: 'LLM', duration: '2 Years', type: 'Master' }
            ],
            exams: [
                { name: 'CLAT', date: 'December' },
                { name: 'AILET', date: 'December' },
                { name: 'LSAT India', date: 'May' }
            ]
        },
        {
            id: 'biz',
            name: 'Management',
            icon: 'fa-briefcase',
            color: 'biz',
            bg: 'from-amber-500 to-orange-900',
            desc: 'Business & Administration',
            why: 'बिजनेस लीडर और मैनेजर बनने के लिए। स्टार्टअप्स और MNCs में शानदार पैकेज।',
            salary: '₹6L - ₹40L',
            careers: ['Manager', 'CEO', 'HR Head', 'Marketing Lead'],
            courses: [
                { name: 'BBA', duration: '3 Years', type: 'Degree' },
                { name: 'MBA', duration: '2 Years', type: 'Master' },
                { name: 'BMS', duration: '3 Years', type: 'Degree' }
            ],
            exams: [
                { name: 'CAT', date: 'November' },
                { name: 'MAT', date: 'Feb/May' },
                { name: 'XAT', date: 'January' }
            ]
        },
        {
            id: 'def',
            name: 'Defence',
            icon: 'fa-shield-alt',
            color: 'tech',
            bg: 'from-green-700 to-emerald-900',
            desc: 'Army, Navy, Airforce',
            why: 'देश सेवा और अनुशासन। इज्जत और जॉब सिक्योरिटी के साथ एडवेंचर।',
            salary: '₹8L - ₹20L',
            careers: ['Army Officer', 'Pilot', 'Sailor', 'Commander'],
            courses: [
                { name: 'NDA (Academy)', duration: '3 Years', type: 'Training' },
                { name: 'CDS (OTA)', duration: '1 Year', type: 'Training' }
            ],
            exams: [
                { name: 'NDA Exam', date: 'Apr/Sep' },
                { name: 'CDS Exam', date: 'Apr/Sep' },
                { name: 'AFCAT', date: 'Feb/Aug' }
            ]
        },
        {
            id: 'des',
            name: 'Design',
            icon: 'fa-palette',
            color: 'brand',
            bg: 'from-pink-500 to-rose-900',
            desc: 'Creative & Fashion',
            why: 'रचनात्मकता दिखाने का मौका। फैशन, ग्राफिक्स और प्रोडक्ट डिजाइन में करियर।',
            salary: '₹4L - ₹15L',
            careers: ['Fashion Designer', 'Graphic Artist', 'UX Designer', 'Animator'],
            courses: [
                { name: 'B.Des', duration: '4 Years', type: 'Degree' },
                { name: 'B.F.Tech', duration: '4 Years', type: 'Degree' },
                { name: 'B.F.A', duration: '4 Years', type: 'Degree' }
            ],
            exams: [
                { name: 'NID DAT', date: 'January' },
                { name: 'NIFT', date: 'February' },
                { name: 'UCEED', date: 'January' }
            ]
        }
    ];

    // --- 2. INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        renderSectorsList();
    });

    function renderSectorsList() {
        const container = document.getElementById('sectors-grid');
        container.innerHTML = '';
        
        sectors.forEach(s => {
            const html = `
                <div onclick="openDetail('${s.id}')" class="glass p-4 rounded-2xl border border-white/5 hover:border-${s.color}-400/50 transition-all active:scale-95 cursor-pointer animate__animated animate__fadeInUp">
                    <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center mb-3 border border-white/10 text-${s.color}-400">
                        <i class="fas ${s.icon} text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-white mb-1">${s.name}</h3>
                    <p class="text-[10px] text-slate-400 line-clamp-1">${s.desc}</p>
                </div>
            `;
            container.innerHTML += html;
        });
    }

    function filterSectors() {
        const input = document.getElementById('sector-search').value.toLowerCase();
        const cards = document.getElementById('sectors-grid').children;
        
        Array.from(cards).forEach(card => {
            const text = card.innerText.toLowerCase();
            card.style.display = text.includes(input) ? 'block' : 'none';
        });
    }

    // --- 3. DETAIL VIEW LOGIC ---
    function openDetail(id) {
        const data = sectors.find(s => s.id === id);
        if(!data) return;

        // Reset Tabs
        switchTab('overview');

        // Populate Header
        document.getElementById('detail-title').innerText = data.name;
        document.getElementById('detail-name').innerText = data.name;
        document.getElementById('detail-desc').innerText = data.desc;
        document.getElementById('detail-hero-bg').className = `h-48 w-full bg-gradient-to-br ${data.bg} relative p-6 flex flex-col justify-end`;

        // Populate Overview Tab
        document.getElementById('detail-why').innerText = data.why;
        document.getElementById('detail-salary').innerText = data.salary;
        
        const careerContainer = document.getElementById('detail-careers');
        careerContainer.innerHTML = '';
        data.careers.forEach(c => {
            careerContainer.innerHTML += `
                <div class="bg-slate-800/50 p-3 rounded-xl border border-white/5 text-center">
                    <span class="text-xs font-bold text-slate-200 block">${c}</span>
                </div>
            `;
        });

        // Populate Courses Tab
        const coursesContainer = document.getElementById('detail-courses-list');
        coursesContainer.innerHTML = '';
        data.courses.forEach(c => {
            coursesContainer.innerHTML += `
                <div class="glass p-4 rounded-xl border border-white/5 flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-white text-sm">${c.name}</h4>
                        <span class="text-[10px] bg-slate-800 px-2 py-0.5 rounded text-slate-400">${c.type}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-brand-400 font-bold block"><i class="far fa-clock"></i> ${c.duration}</span>
                    </div>
                </div>
            `;
        });

        // Populate Exams Tab
        const examsContainer = document.getElementById('detail-exams-list');
        examsContainer.innerHTML = '';
        data.exams.forEach(e => {
            examsContainer.innerHTML += `
                <div class="glass p-4 rounded-xl border border-white/5 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-slate-800 flex items-center justify-center text-yellow-400 font-bold text-xs border border-white/10">
                            <i class="fas fa-pen-alt"></i>
                        </div>
                        <h4 class="font-bold text-white text-sm">${e.name}</h4>
                    </div>
                    <span class="text-xs text-slate-400 bg-slate-800 px-2 py-1 rounded">${e.date}</span>
                </div>
            `;
        });

        // Show View
        document.getElementById('main-view').classList.remove('active-view');
        document.getElementById('main-view').classList.add('hidden-view');
        document.getElementById('detail-view').classList.remove('hidden-view');
        document.getElementById('detail-view').classList.add('active-view');
        
        // Hide Nav
        document.getElementById('bottom-nav').style.display = 'none';
        document.getElementById('detail-view').scrollTop = 0;
    }

    function closeDetail() {
        document.getElementById('detail-view').classList.remove('active-view');
        document.getElementById('detail-view').classList.add('hidden-view');
        document.getElementById('main-view').classList.remove('hidden-view');
        document.getElementById('main-view').classList.add('active-view');
        document.getElementById('bottom-nav').style.display = 'flex';
    }

    function switchTab(tabName) {
        // Hide All
        ['overview', 'courses', 'exams'].forEach(t => {
            document.getElementById(`tab-content-${t}`).classList.add('hidden');
            const btn = document.getElementById(`tab-btn-${t}`);
            btn.classList.remove('tab-active', 'text-brand-400', 'border-b-2', 'border-brand-400', 'font-bold');
            btn.classList.add('tab-inactive', 'text-slate-400', 'font-medium');
        });

        // Show Active
        document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
        const activeBtn = document.getElementById(`tab-btn-${tabName}`);
        activeBtn.classList.remove('tab-inactive', 'text-slate-400', 'font-medium');
        activeBtn.classList.add('tab-active', 'text-brand-400', 'border-b-2', 'border-brand-400', 'font-bold');
    }
</script>

@endsection

```