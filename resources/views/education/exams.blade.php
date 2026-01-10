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
                    gov: { 500: '#f59e0b', 600: '#d97706' }, // Orange for Govt
                    sarkari: { 500: '#ef4444', 600: '#dc2626' } // Red for SarkariExam style
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
    
    /* Loader Animation */
    .loader {
        border: 3px solid rgba(255,255,255,0.1);
        border-left-color: #ec4899;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
</style>

<div class="min-h-screen bg-slate-900 bg-space overflow-x-hidden pb-24">

    <div class="fixed top-0 left-0 right-0 z-40 flex justify-center">
        <div class="w-full max-w-md h-16 bg-slate-900/95 border-b border-white/10 flex items-center justify-between px-4 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <a href="{{ route('education.index') }}" class="w-8 h-8 rounded-full glass flex items-center justify-center text-slate-300 active:scale-90 transition-transform">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <span class="font-bold text-lg tracking-wide">Sarkari Live Finder</span>
            </div>
            <div class="flex items-center gap-2 px-3 py-1 bg-red-500/20 rounded-full border border-red-500/30">
                <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-bold text-red-400 uppercase">Live</span>
            </div>
        </div>
    </div>

    <div class="w-full max-w-md mx-auto relative pt-20 px-4">

        <div class="glass p-5 rounded-2xl border border-white/5 mb-6 animate__animated animate__fadeInDown">
            <h2 class="text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
                <i class="fas fa-filter mr-2 text-brand-400"></i> अपनी योग्यता चुनें
            </h2>
            
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div>
                    <label class="text-[10px] text-slate-400 mb-1 block">Qualification</label>
                    <select id="filter-class" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:border-brand-500 outline-none appearance-none">
                        <option value="10th">10th Pass</option>
                        <option value="12th">12th Pass</option>
                        <option value="graduate">Graduate</option>
                    </select>
                </div>
                
                <div>
                    <label class="text-[10px] text-slate-400 mb-1 block">Sector</label>
                    <select id="filter-sector" class="w-full bg-slate-800 border border-white/10 rounded-xl px-3 py-2 text-sm text-white focus:border-brand-500 outline-none appearance-none">
                        <option value="all">All Sectors</option>
                        <option value="ssc">SSC / Staff Selection</option>
                        <option value="railway">Railway (RRB)</option>
                        <option value="police">Police / Defence</option>
                        <option value="banking">Banking</option>
                    </select>
                </div>
            </div>

            <button onclick="fetchJobs()" class="w-full bg-gradient-to-r from-brand-600 to-purple-600 py-3 rounded-xl font-bold text-white shadow-lg shadow-brand-500/30 active:scale-95 transition-transform flex items-center justify-center gap-2">
                <i class="fas fa-search"></i> Find New Jobs
            </button>
        </div>

        <div id="results-area">
            
            <div id="state-initial" class="text-center py-10 opacity-50">
                <i class="fas fa-newspaper text-4xl mb-3 text-slate-600"></i>
                <p class="text-sm">Search to find latest Sarkari Jobs</p>
            </div>

            <div id="state-loading" class="hidden text-center py-10">
                <div class="loader mx-auto mb-4"></div>
                <p class="text-sm text-brand-400 font-mono">Scraping latest notifications...</p>
            </div>

            <div id="jobs-list" class="space-y-4 hidden">
                </div>

        </div>

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
    // --- 1. MOCK DATABASE OF JOBS ---
    const jobDatabase = [
        { title: "SSC GD Constable 2025", sector: "ssc", qual: "10th", lastDate: "31 Dec", posts: "26,146", link: "https://ssc.nic.in" },
        { title: "RRB NTPC Undergraduate", sector: "railway", qual: "12th", lastDate: "15 Jan", posts: "3,400", link: "https://indianrailways.gov.in" },
        { title: "UP Police Constable", sector: "police", qual: "12th", lastDate: "20 Jan", posts: "60,244", link: "https://uppbpb.gov.in" },
        { title: "SBI Clerk Recruitment", sector: "banking", qual: "graduate", lastDate: "10 Feb", posts: "8,283", link: "https://sbi.co.in" },
        { title: "Indian Army Agniveer", sector: "police", qual: "10th", lastDate: "05 Feb", posts: "25,000+", link: "https://joinindianarmy.nic.in" },
        { title: "SSC CHSL (10+2)", sector: "ssc", qual: "12th", lastDate: "Coming Soon", posts: "4,500", link: "https://ssc.nic.in" },
        { title: "Post Office GDS", sector: "all", qual: "10th", lastDate: "Closed", posts: "30,041", link: "https://indiapostgdsonline.gov.in" },
        { title: "IBPS PO 2025", sector: "banking", qual: "graduate", lastDate: "Aug 2025", posts: "3,049", link: "https://ibps.in" }
    ];

    // --- 2. FETCH FUNCTION ---
    function fetchJobs() {
        const list = document.getElementById('jobs-list');
        const initial = document.getElementById('state-initial');
        const loading = document.getElementById('state-loading');
        
        // UI Reset
        list.classList.add('hidden');
        initial.classList.add('hidden');
        loading.classList.remove('hidden');
        list.innerHTML = '';

        // Get Filters
        const cls = document.getElementById('filter-class').value;
        const sec = document.getElementById('filter-sector').value;

        // Simulate Network Delay (1.5s)
        setTimeout(() => {
            // Filter Logic
            const results = jobDatabase.filter(job => {
                const matchClass = (job.qual === cls) || (cls === 'graduate'); // Simple logic: grads see everything basically
                const matchSector = (sec === 'all') || (job.sector === sec);
                return matchClass && matchSector;
            });

            // Render
            if (results.length === 0) {
                list.innerHTML = `
                    <div class="text-center py-8">
                        <p class="text-slate-400 text-sm">No active jobs found for this filter.</p>
                    </div>`;
            } else {
                // Add header
                list.innerHTML = `<h3 class="text-xs font-bold text-green-400 uppercase mb-2 ml-1">Latest Updates (Live)</h3>`;
                
                results.forEach(job => {
                    list.innerHTML += `
                        <div class="glass p-4 rounded-xl border border-white/5 relative overflow-hidden group hover:border-brand-500/30 transition-all animate__animated animate__fadeInUp">
                            <div class="absolute top-0 right-0 bg-slate-800 px-2 py-1 rounded-bl-lg border-b border-l border-white/5">
                                <span class="text-[10px] text-slate-400">Last Date: <span class="text-white font-bold">${job.lastDate}</span></span>
                            </div>
                            
                            <div class="flex items-start gap-3 mt-1">
                                <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center text-xl shrink-0 border border-white/10">
                                    ${getIcon(job.sector)}
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm leading-tight mb-1">${job.title}</h4>
                                    <div class="flex flex-wrap gap-2 text-[10px]">
                                        <span class="bg-brand-500/10 text-brand-400 px-2 py-0.5 rounded border border-brand-500/20">${job.posts} Posts</span>
                                        <span class="bg-slate-700 text-slate-300 px-2 py-0.5 rounded border border-white/5">${job.qual} Pass</span>
                                    </div>
                                </div>
                            </div>

                            <a href="${job.link}" target="_blank" class="mt-3 block w-full bg-slate-800 hover:bg-slate-700 text-center py-2 rounded-lg text-xs font-bold text-white border border-white/10 transition-colors">
                                Apply Now <i class="fas fa-external-link-alt ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    `;
                });
            }

            loading.classList.add('hidden');
            list.classList.remove('hidden');

        }, 1500);
    }

    function getIcon(sector) {
        switch(sector) {
            case 'ssc': return '<i class="fas fa-file-alt text-blue-400"></i>';
            case 'railway': return '<i class="fas fa-train text-orange-400"></i>';
            case 'police': return '<i class="fas fa-shield-alt text-green-400"></i>';
            case 'banking': return '<i class="fas fa-university text-purple-400"></i>';
            default: return '<i class="fas fa-bullhorn text-brand-400"></i>';
        }
    }
</script>

@endsection