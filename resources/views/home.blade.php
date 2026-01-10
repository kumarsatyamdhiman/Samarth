@extends('layouts.app')

@section('content')

<style>
    :root {
        --insta-gradient: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        --blue-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --text-dark: #1f2937;
        --text-gray: #6b7280;
        --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* ANIMATIONS */
    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .float-icon {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }

    .progress-fill {
        width: 0%; /* Start at 0 for animation */
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* STORY RINGS */
    .story-ring {
        background: var(--insta-gradient);
        padding: 3px;
        border-radius: 50%;
        display: inline-block;
        transition: transform 0.2s;
    }
    .story-ring:active { transform: scale(0.95); }
    
    .story-inner {
        background: #fff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
    }

    /* CARDS */
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.03);
        overflow: hidden;
        position: relative;
        transition: transform 0.2s;
    }
    .modern-card:active { transform: scale(0.98); }

    /* GRID BUTTONS */
    .grid-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: white;
        padding: 20px;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        text-decoration: none;
        color: var(--text-dark);
        transition: transform 0.2s;
        height: 100%;
    }
    .grid-btn:active { transform: scale(0.96); }

    .gradient-text {
        background: var(--insta-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }
</style>

<div style="max-width: 480px; margin: 0 auto; padding-bottom: 90px; overflow-x: hidden;">

    <div class="fade-in-up" style="padding: 15px 0 5px; animation-delay: 0s;">
        <div style="display: flex; overflow-x: auto; gap: 15px; padding: 0 20px; scrollbar-width: none; -ms-overflow-style: none;">
            <div style="text-align: center; flex-shrink: 0;" onclick="location.href='{{ route('goals.index') }}'">
                <div class="story-ring">
                    <div class="story-inner"><i class="fas fa-bullseye" style="color: #f59e0b; font-size: 24px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: #4b5563;">लक्ष्य</div>
            </div>
            <div style="text-align: center; flex-shrink: 0;" onclick="location.href='{{ route('challenges.index') }}'">
                <div class="story-ring">
                    <div class="story-inner"><i class="fas fa-fire" style="color: #ef4444; font-size: 24px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: #4b5563;">चैलेंज</div>
            </div>
            <div style="text-align: center; flex-shrink: 0;" onclick="location.href='{{ route('profile.show') }}'">
                <div class="story-ring">
                    <div class="story-inner"><i class="fas fa-chart-line" style="color: #8b5cf6; font-size: 24px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: #4b5563;">प्रगति</div>
            </div>
            <div style="text-align: center; flex-shrink: 0;" onclick="location.href='{{ route('education.index') }}'">
                <div class="story-ring">
                    <div class="story-inner"><i class="fas fa-graduation-cap" style="color: #3b82f6; font-size: 24px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: #4b5563;">शिक्षा</div>
            </div>
            <div style="text-align: center; flex-shrink: 0;" onclick="location.href='{{ route('videos.index') }}'">
                <div class="story-ring">
                    <div class="story-inner"><i class="fas fa-play" style="color: #ec4899; font-size: 24px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: #4b5563;">वीडियो</div>
            </div>
        </div>
    </div>

    <div class="modern-card fade-in-up" style="margin: 20px; animation-delay: 0.1s;">
        <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: radial-gradient(circle, rgba(236,72,153,0.15) 0%, rgba(255,255,255,0) 70%); border-radius: 50%;"></div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px 20px 5px 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                @php
                    $user = auth()->user();
                    $displayName = $user->profile && $user->profile->display_name ? $user->profile->display_name : $user->username;
                    $initials = strtoupper(substr($displayName, 0, 2));
                @endphp
                <div style="width: 48px; height: 48px; background: #1f2937; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; border: 2px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    {{ $initials }}
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #1f2937; line-height: 1.2;">नमस्ते, {{ $displayName }}!</h4>
                    <span class="gradient-text" style="font-size: 12px; font-weight: 600;">आज का दिन आपका है</span>
                </div>
            </div>
            <div class="float-icon" style="background: #fffbeb; padding: 8px; border-radius: 12px;">
                <i class="fas fa-crown" style="color: #f59e0b; font-size: 18px;"></i>
            </div>
        </div>

        <div style="padding: 10px 20px 20px 20px;">
            <h3 style="margin: 10px 0 5px 0; color: #111827; font-size: 20px; font-weight: 800; line-height: 1.3;">
                सपनों की उड़ान भरें! 🚀
            </h3>
            <p style="margin: 0 0 20px 0; color: #6b7280; font-size: 13px; line-height: 1.5;">
                आपकी यात्रा सही दिशा में है। आज का लक्ष्य पूरा करें!
            </p>

            @php 
                $progressValue = isset($totalProgress) ? round($totalProgress) : 0;
                // If progress is 0, default to 5% visual so bar isn't invisible
                $visualProgress = $progressValue > 0 ? $progressValue : 5;
            @endphp
            
            <div style="background: #f3f4f6; height: 8px; border-radius: 10px; overflow: hidden; position: relative;">
                <div class="progress-fill" 
                     id="dynamicProgressBar"
                     style="height: 100%; background: var(--insta-gradient); border-radius: 10px;"
                     data-width="{{ $visualProgress }}%"></div>
            </div>
            
            <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 700; margin-top: 8px; color: #4b5563;">
                <span><i class="fas fa-check-circle" style="color: #10b981;"></i> <span id="progressText">{{ $progressValue }}</span>% पूर्ण</span>
                <span style="color: #db2777;">लक्ष्य जारी है...</span>
            </div>
        </div>
    </div>

    <div class="fade-in-up" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; padding: 0 20px 25px; animation-delay: 0.2s;">
        <a href="{{ route('goals.index') }}" class="grid-btn">
            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 20px; color: #065f46;"><i class="fas fa-bullseye"></i></div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700;">लक्ष्य चुनें</h4>
            <span style="font-size: 10px; color: #9ca3af; margin-top: 2px;">भविष्य की योजना</span>
        </a>
        <a href="{{ route('challenges.index') }}" class="grid-btn">
            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #fccb90 0%, #d57eeb 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 20px; color: #86198f;"><i class="fas fa-trophy"></i></div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700;">चैलेंज</h4>
            <span style="font-size: 10px; color: #9ca3af; margin-top: 2px;">रोज़ छोटे कदम</span>
        </a>
        <a href="{{ route('education.index') }}" class="grid-btn">
            <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 20px; color: #1e3a8a;"><i class="fas fa-book-open"></i></div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700;">शिक्षा गाइड</h4>
            <span style="font-size: 10px; color: #9ca3af; margin-top: 2px;">स्ट्रीम और करियर</span>
        </a>
        <a href="{{ route('profile.show') }}" class="grid-btn">
            <div style="width: 45px; height: 45px; background: #f3f4f6; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 20px; color: #374151;"><i class="fas fa-user-circle"></i></div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700;">प्रोफ़ाइल</h4>
            <span style="font-size: 10px; color: #9ca3af; margin-top: 2px;">सेटिंग्स</span>
        </a>
    </div>

    @if(isset($educationProfile) && $educationProfile && $educationProfile->isCompleted())
    <div class="fade-in-up" style="padding: 0 20px 20px; animation-delay: 0.25s;">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
            <i class="fas fa-graduation-cap" style="color: #3b82f6;"></i>
            <h3 style="font-size: 16px; font-weight: 800; color: #111827; margin: 0;">आपकी शिक्षा योजना</h3>
        </div>
        <div class="modern-card" style="padding: 15px; margin-bottom: 12px; border-radius: 16px; border-left: 4px solid #3b82f6;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6;"><i class="fas fa-book"></i></div>
                <div style="flex: 1;">
                    <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #1f2937;">
                        कक्षा {{ $educationProfile->current_class }} - {{ ucfirst($educationProfile->planned_stream ?? 'Stream') }}
                    </h4>
                    <p style="margin: 4px 0 0 0; font-size: 11px; color: #6b7280;">अपनी योजना पर बने रहें</p>
                </div>
                <a href="{{ route('education.index') }}" style="width: 32px; height: 32px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;"><i class="fas fa-arrow-right" style="font-size: 12px;"></i></a>
            </div>
        </div>
    </div>
    @endif

    <div class="fade-in-up" style="padding: 0 20px 30px; animation-delay: 0.4s;">
        <div class="modern-card" style="background: #000; color: white; border-radius: 20px; overflow: hidden; min-height: 200px; display: flex; flex-direction: column; justify-content: flex-end;">
            <div style="position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80') center/cover;"></div>
            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.9) 10%, rgba(0,0,0,0.2) 100%);"></div>
            <div style="position: relative; z-index: 10; padding: 25px;">
                <i class="fas fa-quote-left" style="font-size: 20px; color: rgba(255,255,255,0.6); margin-bottom: 10px;"></i>
                <h3 style="font-size: 18px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">"शिक्षा वह हथियार है जिससे आप पूरी दुनिया बदल सकते हैं।"</h3>
                <p style="font-size: 12px; color: rgba(255,255,255,0.8); margin-bottom: 20px;">- नेल्सन मंडेला</p>
                <a href="{{ route('education.index') }}" style="background: white; color: black; padding: 10px 20px; border-radius: 30px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-block;">अधिक जानें</a>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding-bottom: 20px;">
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: #9ca3af; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; margin: 0 auto;">
                <i class="fas fa-sign-out-alt"></i> लॉग आउट
            </button>
        </form>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trigger Progress Bar Animation
        const bar = document.getElementById('dynamicProgressBar');
        if(bar) {
            // Small delay to ensure transition is visible
            setTimeout(() => {
                const targetWidth = bar.getAttribute('data-width');
                bar.style.width = targetWidth;
            }, 300);
        }

        // Add Touch/Click feedback
        const interactiveElements = document.querySelectorAll('.modern-card, .grid-btn, .story-ring');
        interactiveElements.forEach(el => {
            el.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.96)';
            });
            el.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>

@endsection