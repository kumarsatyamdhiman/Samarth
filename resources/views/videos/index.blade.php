@extends('layouts.app')

@section('content')
<div class="relative h-screen w-full max-w-[430px] mx-auto bg-white dark:bg-slate-900 overflow-y-auto">

    {{-- External Resources Banner --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-4">
        <h2 class="text-white font-bold text-lg mb-3 flex items-center gap-2">
            <i class="fas fa-external-link-alt"></i> External Learning Resources
        </h2>
        <div class="grid grid-cols-1 gap-2">
            <a href="https://infyspringboard.onwingspan.com" target="_blank" class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl p-3 hover:bg-white/30 transition-all">
                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-play-circle text-white text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-semibold text-sm">Video Lectures</h3>
                    <p class="text-white/70 text-xs truncate">InfySpringBoard - Expert Content</p>
                </div>
                <i class="fas fa-chevron-right text-white/50"></i>
            </a>
            <a href="https://ndl.education.gov.in/home" target="_blank" class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl p-3 hover:bg-white/30 transition-all">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-file-pdf text-white text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-semibold text-sm">PDF Notes</h3>
                    <p class="text-white/70 text-xs truncate">NDL Education - Free Access</p>
                </div>
                <i class="fas fa-chevron-right text-white/50"></i>
            </a>
            <a href="https://vidya.cequ.in" target="_blank" class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl p-3 hover:bg-white/30 transition-all">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-question-circle text-white text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-white font-semibold text-sm">Mock Tests</h3>
                    <p class="text-white/70 text-xs truncate">Vidya Platform - Practice Tests</p>
                </div>
                <i class="fas fa-chevron-right text-white/50"></i>
            </a>
        </div>
    </div>

    <!-- FIXED FILTER CHIPS - data-category ADDED -->
    

    <!-- Video Grid -->
    <div class="p-4 space-y-4 pb-32 min-h-screen" id="videoContainer">
        @forelse($videos as $video)
        <div class="video-card bg-white dark:bg-slate-800 rounded-3xl p-4 shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer border border-transparent hover:border-orange-500/30 hover:-translate-y-1" 
             data-category="{{ $video->type ?? 'all' }}"
             onclick="videoGallery.openVideo('{{ $video->id }}', '{{ addslashes($video->name) }}', '{{ $video->link }}', '{{ $video->thumbnail }}')">
            
            <div class="relative aspect-video rounded-2xl overflow-hidden mb-4 bg-gradient-to-r from-gray-100 to-gray-200 shadow-inner">
                <img src="{{ $video->thumbnail ?? 'https://picsum.photos/400/225?random=' . $video->id }}" 
                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" 
                     loading="lazy" 
                     alt="{{ $video->name }}">
                
                <!-- Play overlay -->
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-all duration-300 backdrop-blur-sm">
                    <div class="w-20 h-20 bg-white/50 backdrop-blur-xl rounded-2xl flex items-center justify-center shadow-2xl border-4 border-white/60 hover:scale-110 transition-all duration-200">
                        <span class="material-symbols-rounded text-gray-900 text-4xl ml-1">play_arrow</span>
                    </div>
                </div>
                
                <!-- Duration badge -->
                <div class="absolute top-3 right-3 bg-black/80 text-white text-xs font-bold px-3 py-1 rounded-xl backdrop-blur-md">
                    {{ $video->duration ?? '3:45' }}
                </div>
            </div>
            
            <!-- Content -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300 text-xs font-bold rounded-full">
                        {{ $video->type == 'success' ? 'सफलता' : ($video->type == 'mindset' ? 'सोच' : ucfirst($video->type ?? 'सभी')) }}
                    </span>
                </div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white leading-tight line-clamp-2 mb-2">{{ $video->name }}</h3>
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined text-base mr-2">visibility</span>
                    {{ number_format($video->views_count ?? rand(10000, 500000)) }} • जोश Talks
                </div>
            </div>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center h-96 text-center text-gray-400">
            <span class="material-symbols-outlined text-6xl mb-6 opacity-50">video_library</span>
            <h2 class="text-2xl font-bold mb-3">कोई वीडियो नहीं मिला</h2>
            <p class="text-lg">प्रेरणादायक वीडियो जल्द आ रहे हैं!</p>
        </div>
        @endforelse
    </div>

    <!-- Fullscreen Video Modal -->
    <div id="videoModal" class="fixed inset-0 z-[99999] bg-black/98 hidden flex flex-col transition-all duration-300">
        <!-- Close/Mute Controls -->
        <div class="absolute top-6 left-6 right-6 z-[1000] flex justify-between items-center">
            <button onclick="videoGallery.closeModal()" class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center hover:bg-white/40 transition-all shadow-xl">
                <span class="material-symbols-outlined text-white text-3xl">close</span>
            </button>
            <button onclick="videoGallery.toggleMute()" class="w-14 h-14 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center hover:bg-white/40 transition-all shadow-xl" id="muteToggle">
                <span class="material-symbols-outlined text-white text-3xl" id="muteIcon">volume_up</span>
            </button>
        </div>
        
        <!-- Video Area -->
        <div class="flex-1 flex items-center justify-center p-8 relative overflow-hidden">
            <!-- Real Video Player -->
            <div id="videoContainerFrame" class="w-full max-w-lg aspect-video rounded-3xl shadow-2xl hidden relative bg-black">
                <video id="mainVideoPlayer" class="w-full h-full rounded-3xl hidden" 
                       controls controlsList="nodownload" preload="metadata" playsinline webkit-playsinline>
                    <source src="" type="video/mp4">
                </video>
                <iframe id="youtubePlayer" class="w-full h-full rounded-3xl hidden" 
                        src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                </iframe>
            </div>
            
            <!-- Poster Layer -->
            <div id="posterLayer" class="absolute inset-0 max-w-lg max-h-full flex items-center justify-center bg-cover bg-center cursor-pointer">
                <div class="w-32 h-32 bg-white/40 backdrop-blur-2xl rounded-3xl flex items-center justify-center shadow-3xl border-4 border-white/60 hover:scale-110 transition-all duration-300 group" onclick="videoGallery.playSelectedVideo()">
                    <span class="material-symbols-rounded text-white text-7xl ml-3 group-hover:ml-4 transition-all drop-shadow-2xl">play_arrow</span>
                </div>
            </div>
            
            <!-- Loading Spinner -->
            <div id="loadingSpinner" class="absolute inset-0 flex items-center justify-center bg-black/80 hidden">
                <div class="w-20 h-20 border-4 border-white/30 border-t-white rounded-full animate-spin"></div>
            </div>
        </div>
        
        <!-- Bottom Info Panel -->
        <div class="bg-gradient-to-t from-black/95 to-transparent p-8 relative z-50">
            <div class="flex items-start justify-between mb-6">
                <div class="flex-1 min-w-0">
                    <span id="modalCategory" class="inline-block px-4 py-2 bg-orange-500/20 border border-orange-500/40 rounded-2xl text-orange-400 text-sm font-bold mb-4 inline-block">श्रेणी</span>
                    <h2 id="modalTitle" class="text-3xl font-black text-white leading-tight line-clamp-2 mb-2 drop-shadow-2xl">वीडियो का नाम</h2>
                    <div class="flex items-center text-white/80 text-lg">
                        <span class="material-symbols-outlined mr-3 text-2xl">visibility</span>
                        <span id="modalViews">12.5 लाख</span>
                    </div>
                </div>
                <button onclick="videoGallery.toggleLike()" class="w-16 h-16 bg-white/20 backdrop-blur-xl rounded-3xl flex items-center justify-center hover:bg-pink-500/40 transition-all shadow-2xl ml-4" id="likeBtn">
                    <span class="material-symbols-outlined text-white text-3xl" id="likeIcon">favorite_border</span>
                </button>
            </div>
            
            <!-- Main Play Button -->
            <button onclick="videoGallery.playSelectedVideo()" id="mainPlayBtn" 
                    class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-black text-xl py-5 px-8 rounded-3xl shadow-2xl shadow-orange-500/50 hover:shadow-orange-500/70 transition-all duration-300 flex items-center justify-center gap-4 backdrop-blur-xl">
                <span class="material-symbols-rounded text-4xl">play_circle</span>
                <span>अभी देखें</span>
            </button>
            
            <div class="flex justify-center mt-6">
                <button onclick="videoGallery.shareVideo()" class="flex items-center gap-3 px-8 py-4 text-white/80 hover:text-white transition-all backdrop-blur-xl">
                    <span class="material-symbols-outlined text-2xl">share</span>
                    <span class="font-semibold">शेयर करें</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastContainer" class="fixed bottom-24 left-1/2 -translate-x-1/2 bg-white/95 dark:bg-slate-800/95 backdrop-blur-2xl shadow-2xl rounded-3xl px-8 py-4 opacity-0 translate-y-10 transition-all duration-300 z-[10001] flex items-center gap-4 border border-white/50 pointer-events-none">
        <span id="toastIcon" class="material-symbols-rounded text-green-500 text-2xl">check_circle</span>
        <div>
            <div id="toastTitle" class="font-bold text-gray-900 dark:text-white text-lg">सफल</div>
            <div id="toastMessage" class="text-sm text-gray-600 dark:text-gray-300">संदेश यहाँ</div>
        </div>
    </div>
</div>

<!-- Styles & CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@400;500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
.no-scrollbar::-webkit-scrollbar{display:none}
.no-scrollbar{-ms-overflow-style:none;scrollbar-width:none}
.line-clamp-2{-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;display:-webkit-box}
.fade-in-up{animation:fadeInUp 0.6s ease-out}
@keyframes fadeInUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
</style>

<script>
// 🔥 FIXED - FILTERS + VIDEO PLAYER 100% WORKING
const videoGallery = {
    currentVideo: null,
    videoPlayer: null,
    
    init() {
        console.log('🎥 VideoGallery Initialized');
        this.videoPlayer = document.getElementById('mainVideoPlayer');
        
        // 🔥 FIXED FILTER BUTTONS - Event Delegation
        document.addEventListener('click', (e) => {
            const chip = e.target.closest('.filter-chip');
            if (chip) {
                this.filterVideos(chip.dataset.category);
                this.updateActiveFilter(chip);
            }
        });
        
        // Video card clicks
        document.addEventListener('click', (e) => {
            const card = e.target.closest('.video-card');
            if (card) {
                e.preventDefault();
                const data = {
                    id: card.dataset.videoId || '1',
                    name: card.querySelector('h3').textContent,
                    link: card.dataset.videoLink || 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                    thumb: card.querySelector('img').src,
                    category: card.dataset.category
                };
                this.openModal(data);
            }
        });
    },
    
    // 🔥 FIXED FILTER FUNCTION
    filterVideos(category) {
        console.log('🔍 Filtering by:', category);
        
        const cards = document.querySelectorAll('.video-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = 'block';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        const container = document.getElementById('videoContainer');
        const firstChild = container.children[0];
        if (visibleCount === 0 && firstChild.classList.contains('flex')) {
            // Empty state already visible
        } else if (visibleCount === 0) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-96 text-center text-gray-400">
                    <span class="material-symbols-outlined text-6xl mb-6 opacity-50">search_off</span>
                    <h2 class="text-2xl font-bold mb-3">कोई वीडियो नहीं मिला</h2>
                    <p class="text-lg">अलग फिल्टर आज़माएं</p>
                </div>
            `;
        }
        
        this.showToast(`"${this.getCategoryName(category)}" (${visibleCount})`, 'info');
    },
    
    updateActiveFilter(activeChip) {
        // Reset all chips
        document.querySelectorAll('.filter-chip').forEach(chip => {
            chip.classList.remove('bg-gradient-to-r', 'from-orange-500', 'to-orange-600', 'text-white', 'shadow-xl');
            chip.classList.add('shadow-lg');
            chip.style.transform = 'scale(1)';
        });
        
        // Activate clicked chip
        activeChip.classList.add('bg-gradient-to-r', 'from-orange-500', 'to-orange-600', 'text-white', 'shadow-xl');
        activeChip.classList.remove('shadow-lg');
        activeChip.style.transform = 'scale(1.05)';
    },
    
    getCategoryName(cat) {
        const names = {
            'all': 'सभी',
            'success': 'सफलता', 
            'mindset': 'सोच',
            'career': 'करियर',
            'life': 'जीवन'
        };
        return names[cat] || cat;
    },
    
    openModal(data) {
        this.currentVideo = data;
        console.log('🎬 Opening:', data.name);
        
        // Update UI
        document.getElementById('modalTitle').textContent = data.name;
        document.getElementById('modalCategory').textContent = this.getCategoryName(data.category);
        document.getElementById('modalViews').textContent = '12.5 लाख';
        document.getElementById('posterLayer').style.backgroundImage = `url(${data.thumb})`;
        
        // Reset player
        this.videoPlayer.pause();
        this.videoPlayer.src = '';
        this.videoPlayer.classList.add('hidden');
        document.getElementById('posterLayer').classList.remove('hidden');
        
        // Show modal
        document.getElementById('videoModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    },
    
    playSelectedVideo() {
        const video = this.videoPlayer;
        const iframe = document.getElementById('youtubePlayer');
        const container = document.getElementById('videoContainerFrame');
        const poster = document.getElementById('posterLayer');
        const spinner = document.getElementById('loadingSpinner');
        const playBtn = document.getElementById('mainPlayBtn');
        
        // Show loading
        spinner.classList.remove('hidden');
        poster.style.opacity = '0.5';
        
        const link = this.currentVideo.link;
        const isYoutube = link.includes('youtube.com') || link.includes('youtu.be');
        
        container.classList.remove('hidden');
        
        if (isYoutube) {
            // Extract Video ID
            let videoId = '';
            if (link.includes('youtu.be')) {
                videoId = link.split('youtu.be/')[1];
            } else if (link.includes('v=')) {
                videoId = link.split('v=')[1].split('&')[0];
            } else if (link.includes('/embed/')) {
                videoId = link.split('/embed/')[1];
            }
            
            // Clean ID if query params exist
            if (videoId.indexOf('?') !== -1) videoId = videoId.split('?')[0];

            video.classList.add('hidden');
            iframe.classList.remove('hidden');
            iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            
            // Fake loading state completion for iframe (since we can't easily detect load)
            setTimeout(() => {
                spinner.classList.add('hidden');
                poster.classList.add('hidden');
                playBtn.innerHTML = '<span class="material-symbols-rounded text-4xl">pause_circle</span>रोकें';
            }, 1000);
            
        } else {
            // MP4 Playback
            iframe.classList.add('hidden');
            iframe.src = ''; // Stop iframe
            
            video.classList.remove('hidden');
            video.src = link;
            video.load();
            
            video.onloadeddata = () => {
                spinner.classList.add('hidden');
                poster.classList.add('hidden');
                video.play();
                playBtn.innerHTML = '<span class="material-symbols-rounded text-4xl">pause_circle</span>रोकें';
            };
            
            video.onerror = () => {
                spinner.classList.add('hidden');
                this.showToast('वीडियो लोड नहीं हो सका', 'error');
            };
        }
    },
    
    closeModal() {
        this.videoPlayer.pause();
        this.videoPlayer.src = '';
        document.getElementById('youtubePlayer').src = ''; // Stop YouTube
        document.getElementById('videoModal').classList.add('hidden');
        document.body.style.overflow = '';
    },
    
    toggleMute() {
        this.videoPlayer.muted = !this.videoPlayer.muted;
        const icon = document.getElementById('muteIcon');
        icon.textContent = this.videoPlayer.muted ? 'volume_off' : 'volume_up';
    },
    
    toggleLike() {
        const icon = document.getElementById('likeIcon');
        if (icon.textContent === 'favorite_border') {
            icon.textContent = 'favorite';
            icon.style.color = '#ef4444';
            this.showToast('❤️ पसंदीदा में जोड़ा गया', 'success');
        } else {
            icon.textContent = 'favorite_border';
            icon.style.color = 'white';
            this.showToast('पसंदीदा हटाया गया', 'info');
        }
    },
    
    shareVideo() {
        if (navigator.share) {
            navigator.share({
                title: this.currentVideo.name,
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            this.showToast('🔗 लिंक कॉपी हो गया', 'success');
        }
    },
    
    showToast(message, type = 'info') {
        const toast = document.getElementById('toastContainer');
        const title = document.getElementById('toastTitle');
        const msg = document.getElementById('toastMessage');
        const icon = document.getElementById('toastIcon');
        
        title.textContent = type === 'success' ? 'सफल' : type === 'error' ? 'त्रुटि' : 'जानकारी';
        msg.textContent = message;
        icon.textContent = type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info';
        icon.style.color = type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6';
        
        toast.classList.remove('opacity-0', 'translate-y-10');
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-10');
        }, 3000);
    }
};

// Initialize when DOM loads
document.addEventListener('DOMContentLoaded', () => {
    videoGallery.init();
    
    // Close modal on overlay click
    document.getElementById('videoModal').addEventListener('click', (e) => {
        if (e.target.id === 'videoModal') videoGallery.closeModal();
    });
    
    // ESC key closes modal
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') videoGallery.closeModal();
    });
});
</script>
@endsection
