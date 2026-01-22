@extends('layouts.app')

@section('content')

<style>
    :root {
        --insta-gradient: linear-gradient(45deg, #ea580c 0%, #f97316 50%, #fbbf24 100%);
        --space-gradient: linear-gradient(135deg, #020617 0%, #1e1b4b 100%);
    }

    .fade-in-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-out forwards;
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
        width: 0%;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .story-ring {
        background: var(--insta-gradient);
        padding: 3px;
        border-radius: 50%;
        display: inline-block;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .story-ring:hover {
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(234, 88, 12, 0.5);
    }
    
    .story-inner {
        background: linear-gradient(135deg, #1e1b4b, #0f172a);
        border-radius: 50%;
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255,255,255,0.1);
    }

    .story-inner i {
        background: var(--insta-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div style="max-width: 480px; margin: 0 auto; padding-bottom: 90px; overflow-x: hidden;">

    <!-- Stories Row -->
    <div class="fade-in-up" style="padding: 15px 0 5px; animation-delay: 0s;">
        <div style="display: flex; overflow-x: auto; gap: 15px; padding: 0 20px; scrollbar-width: none; -ms-overflow-style: none; justify-content: center;" class="no-scrollbar">
            <div style="text-align: center; flex-shrink: 0; cursor: pointer;" onclick="location.href='{{ route('goals.index') }}'">
                <div class="story-ring" style="display: flex; align-items: center; justify-content: center;">
                    <div class="story-inner" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-bullseye" style="font-size: 22px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: rgba(255,255,255,0.7); text-align: center;">लक्ष्य</div>
            </div>
            <div style="text-align: center; flex-shrink: 0; cursor: pointer;" onclick="location.href='{{ route('challenges.index') }}'">
                <div class="story-ring" style="display: flex; align-items: center; justify-content: center;">
                    <div class="story-inner" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-fire" style="font-size: 22px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: rgba(255,255,255,0.7); text-align: center;">चैलेंज</div>
            </div>
            <div style="text-align: center; flex-shrink: 0; cursor: pointer;" onclick="location.href='{{ route('profile.show') }}'">
                <div class="story-ring" style="display: flex; align-items: center; justify-content: center;">
                    <div class="story-inner" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-chart-line" style="font-size: 22px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: rgba(255,255,255,0.7); text-align: center;">प्रगति</div>
            </div>
            <div style="text-align: center; flex-shrink: 0; cursor: pointer;" onclick="location.href='{{ route('education.index') }}'">
                <div class="story-ring" style="display: flex; align-items: center; justify-content: center;">
                    <div class="story-inner" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-graduation-cap" style="font-size: 22px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: rgba(255,255,255,0.7); text-align: center;">शिक्षा</div>
            </div>
            <div style="text-align: center; flex-shrink: 0; cursor: pointer;" onclick="location.href='{{ route('videos.index') }}'">
                <div class="story-ring" style="display: flex; align-items: center; justify-content: center;">
                    <div class="story-inner" style="width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;"><i class="fas fa-play" style="font-size: 22px;"></i></div>
                </div>
                <div style="font-size: 11px; font-weight: 600; margin-top: 5px; color: rgba(255,255,255,0.7); text-align: center;">वीडियो</div>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="glass-card glass-card-hover fade-in-up" style="margin: 20px; animation-delay: 0.1s; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: radial-gradient(circle, rgba(234, 88, 12, 0.3) 0%, transparent 70%); border-radius: 50%;"></div>

        <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px 20px 5px 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
@php
                    $currentUser = $user ?? null;
                    $displayName = 'Guest';
                    $initials = 'GU';
                    if ($currentUser) {
                        // Handle both array and object - prioritize first_name
                        if (is_array($currentUser)) {
                            $firstName = $currentUser['first_name'] ?? '';
                            $displayName = $firstName ?: ($currentUser['username'] ?? 'User');
                        } else {
                            $firstName = $currentUser->first_name ?? '';
                            $displayName = $firstName ?: ($currentUser->username ?? 'User');
                        }
                        $initials = strtoupper(substr($displayName, 0, 2));
                    }
                @endphp
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ea580c, #f97316); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; box-shadow: 0 4px 20px rgba(234, 88, 12, 0.4);">
                    {{ $initials }}
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: white; line-height: 1.2;">नमस्ते, {{ $displayName }}!</h4>
                    <span class="gradient-text" style="font-size: 12px; font-weight: 600;">आज का दिन आपका है</span>
                </div>
            </div>
            <div class="float-icon" style="background: rgba(234, 88, 12, 0.2); padding: 10px; border-radius: 12px; border: 1px solid rgba(234, 88, 12, 0.3);">
                <i class="fas fa-crown" style="color: #fbbf24; font-size: 18px;"></i>
            </div>
        </div>

        <div style="padding: 10px 20px 20px 20px;">
            <h3 style="margin: 15px 0 8px 0; color: white; font-size: 20px; font-weight: 800; line-height: 1.3;">
                सपनों की उड़ान भरें! 🚀
            </h3>
            <p style="margin: 0 0 20px 0; color: rgba(255,255,255,0.6); font-size: 13px; line-height: 1.5;">
                आपकी यात्रा सही दिशा में है। आज का लक्ष्य पूरा करें!
            </p>

            @php 
                $progressValue = isset($userProgressData) && $userProgressData ? round($userProgressData['progress_percentage']) : 0;
                $earnedPoints = isset($userProgressData) && $userProgressData ? $userProgressData['earned_points'] : 0;
                $totalPoints = isset($userProgressData) && $userProgressData ? $userProgressData['total_points'] : 535;
                $visualProgress = $progressValue > 0 ? $progressValue : 5;
            @endphp
            
            <div style="background: rgba(255,255,255,0.1); height: 10px; border-radius: 10px; overflow: hidden; position: relative;">
                <div class="progress-fill" 
                     id="dynamicProgressBar"
                     style="height: 100%; background: var(--insta-gradient); border-radius: 10px;"
                     data-width="{{ $visualProgress }}%"></div>
            </div>
            
            <div style="display: flex; justify-content: space-between; font-size: 11px; font-weight: 600; margin-top: 10px; color: rgba(255,255,255,0.7);">
                <span><i class="fas fa-check-circle" style="color: #22c55e;"></i> <span id="progressText">{{ $progressValue }}</span>% पूर्ण</span>
                <span style="color: #fbbf24;"><i class="fas fa-star"></i> {{ $earnedPoints }} / {{ $totalPoints }} pts</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions Grid -->
    <div class="fade-in-up" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding: 0 20px 25px; animation-delay: 0.2s;">
        <a href="{{ route('goals.index') }}" class="glass-card glass-card-hover" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(34, 197, 94, 0.1)); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 22px; border: 1px solid rgba(34, 197, 94, 0.3);">
                <i class="fas fa-bullseye" style="color: #22c55e;"></i>
            </div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: white;">लक्ष्य चुनें</h4>
            <span style="font-size: 10px; color: rgba(255,255,255,0.5); margin-top: 4px;">भविष्य की योजना</span>
        </a>
        <a href="{{ route('challenges.index') }}" class="glass-card glass-card-hover" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(234, 88, 12, 0.2), rgba(234, 88, 12, 0.1)); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 22px; border: 1px solid rgba(234, 88, 12, 0.3);">
                <i class="fas fa-trophy" style="color: #ea580c;"></i>
            </div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: white;">चैलेंज</h4>
            <span style="font-size: 10px; color: rgba(255,255,255,0.5); margin-top: 4px;">रोज़ छोटे कदम</span>
        </a>
        <a href="{{ route('education.index') }}" class="glass-card glass-card-hover" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(59, 130, 246, 0.1)); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 22px; border: 1px solid rgba(59, 130, 246, 0.3);">
                <i class="fas fa-book-open" style="color: #3b82f6;"></i>
            </div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: white;">शिक्षा गाइड</h4>
            <span style="font-size: 10px; color: rgba(255,255,255,0.5); margin-top: 4px;">स्ट्रीम और करियर</span>
        </a>
        <a href="{{ route('profile.show') }}" class="glass-card glass-card-hover" style="padding: 20px; text-decoration: none; display: flex; flex-direction: column; align-items: center;">
            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; font-size: 22px; border: 1px solid rgba(255,255,255,0.1);">
                <i class="fas fa-user-circle" style="color: white;"></i>
            </div>
            <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: white;">प्रोफ़ाइल</h4>
            <span style="font-size: 10px; color: rgba(255,255,255,0.5); margin-top: 4px;">सेटटिंग्स</span>
        </a>
    </div>

    <!-- Education Profile Card -->
    @if(isset($educationProfile) && $educationProfile && $educationProfile->isCompleted())
    <div class="fade-in-up" style="padding: 0 20px 20px; animation-delay: 0.25s;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
            <i class="fas fa-graduation-cap" style="color: #fbbf24;"></i>
            <h3 style="font-size: 16px; font-weight: 800; color: white; margin: 0;">आपकी शिक्षा योजना</h3>
        </div>
        <div class="glass-card" style="padding: 15px; border-left: 4px solid #fbbf24;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; background: linear-gradient(135deg, rgba(251, 191, 36, 0.2), rgba(251, 191, 36, 0.1)); border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(251, 191, 36, 0.3);">
                    <i class="fas fa-book" style="color: #fbbf24;"></i>
                </div>
                <div style="flex: 1;">
                    <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: white;">
                        कक्षा {{ $educationProfile->current_class }} - {{ ucfirst($educationProfile->planned_stream ?? 'Stream') }}
                    </h4>
                    <p style="margin: 4px 0 0 0; font-size: 11px; color: rgba(255,255,255,0.5);">अपनी योजना पर रहें</p>
                </div>
                <a href="{{ route('education.index') }}" style="width: 36px; height: 36px; background: linear-gradient(135deg, #ea580c, #f97316); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);">
                    <i class="fas fa-arrow-right" style="font-size: 14px;"></i>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Quote Card -->
    <div class="fade-in-up" style="padding: 0 20px 30px; animation-delay: 0.4s;">
        <div class="glass-card" style="background: linear-gradient(135deg, rgba(30, 27, 75, 0.8), rgba(15, 23, 42, 0.9)); color: white; border-radius: 20px; overflow: hidden; min-height: 180px; display: flex; flex-direction: column; justify-content: flex-end; position: relative; border: 1px solid rgba(255,255,255,0.1);">
            <div style="position: absolute; inset: 0; background: radial-gradient(circle at center, rgba(255,255,255,0.03) 0%, transparent 70%);"></div>
            <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(2, 6, 23, 0.95) 10%, rgba(2, 6, 23, 0.3) 100%);"></div>
            
            <div style="position: relative; z-index: 10; padding: 25px;">
                <i class="fas fa-quote-left" style="font-size: 24px; color: rgba(251, 191, 36, 0.6); margin-bottom: 12px;"></i>
                <h3 style="font-size: 17px; font-weight: 700; line-height: 1.5; margin-bottom: 10px; color: white;">"शिक्षा वह हथियार है जिससे आप पूरी दुनिया बदल सकते हैं।"</h3>
                <p style="font-size: 12px; color: rgba(255,255,255,0.6); margin-bottom: 20px;">- नेल्सन मंडेला</p>
                <a href="{{ route('education.index') }}" class="btn-primary" style="padding: 10px 24px; border-radius: 30px; font-size: 12px; font-weight: 700; text-decoration: none; display: inline-block; color: white;">अधिक जानें</a>
            </div>
        </div>
    </div>

    <!-- Login/Logout Button -->
    <div style="text-align: center; padding-bottom: 20px;">
        @if(isset($user) && $user)
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; margin: 0 auto; padding: 10px 20px; border-radius: 30px; transition: all 0.3s;">
                <i class="fas fa-sign-out-alt"></i> लॉग आउट
            </button>
        </form>
        @else
        <a href="{{ route('login.show') }}" style="background: linear-gradient(135deg, #ea580c, #f97316); color: white; font-size: 13px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 24px; border-radius: 30px; text-decoration: none; box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);">
            <i class="fas fa-sign-in-alt"></i> लॉग इन करें
        </a>
        @endif
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bar = document.getElementById('dynamicProgressBar');
        if(bar) {
            setTimeout(() => {
                const targetWidth = bar.getAttribute('data-width');
                bar.style.width = targetWidth;
            }, 300);
        }

        const interactiveElements = document.querySelectorAll('.glass-card, .story-ring, .btn-primary');
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
