@extends('layouts.app')

@section('content')

<style>
    :root {
        --insta-gradient: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
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

    .scale-in {
        animation: scaleIn 0.5s ease-out forwards;
        transform: scale(0.9);
        opacity: 0;
    }

    @keyframes scaleIn {
        to { transform: scale(1); opacity: 1; }
    }

    /* PROFILE HEADER */
    .profile-header-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 20px 60px;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        color: white;
        text-align: center;
        position: relative;
        margin-bottom: 50px;
    }

    .profile-avatar-container {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 100px;
        padding: 4px;
        background: white;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: var(--insta-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 800;
        color: white;
        border: 4px solid white;
    }

    /* MODERN CARD */
    .modern-card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.03);
        overflow: hidden;
        margin-bottom: 20px;
        transition: transform 0.2s;
    }
    .modern-card:active { transform: scale(0.99); }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding: 20px;
        text-align: center;
    }
    .stat-item h3 { font-size: 20px; font-weight: 800; margin: 0; color: var(--text-dark); }
    .stat-item p { font-size: 11px; color: var(--text-gray); margin: 2px 0 0; font-weight: 600; text-transform: uppercase; }

    /* FORM STYLES */
    .custom-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #f3f4f6;
        border-radius: 12px;
        font-size: 14px;
        color: var(--text-dark);
        transition: border-color 0.3s;
        outline: none;
        background: #f9fafb;
    }
    .custom-input:focus { border-color: #8b5cf6; background: white; }

    .action-btn {
        background: var(--insta-gradient);
        color: white;
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: 0 4px 10px rgba(220, 39, 67, 0.3);
    }
    .action-btn:active { transform: scale(0.97); }

    /* BADGES */
    .achievement-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #fff;
        padding: 15px;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(0,0,0,0.03);
    }
    .badge-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        font-size: 18px;
    }
</style>

<div style="max-width: 480px; margin: 0 auto; padding-bottom: 90px; overflow-x: hidden;">

    <div class="profile-header-bg fade-in-up">
        <div style="position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.2); padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;">
            <i class="fas fa-crown text-yellow-300 mr-1"></i> Premium
        </div>
        
        <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 5px;">{{ $profile->display_name ?? $user->username }}</h1>
        <p style="font-size: 13px; opacity: 0.9;"><i class="far fa-calendar-alt mr-1"></i> Member since {{ $user->created_at->format('M Y') }}</p>

        <div class="profile-avatar-container scale-in" style="animation-delay: 0.2s;">
            <div class="profile-avatar">
                {{ strtoupper(substr($profile->display_name ?? $user->username, 0, 2)) }}
            </div>
        </div>
    </div>

    <div class="modern-card fade-in-up" style="margin: 0 20px 20px; animation-delay: 0.3s;">
        <div class="stats-grid">
            <div class="stat-item">
                <h3 style="color: #f59e0b;">{{ $totalPoints ?? 0 }}</h3>
                <p>कुल अंक</p>
            </div>
            <div class="stat-item" style="border-left: 1px solid #f3f4f6; border-right: 1px solid #f3f4f6;">
                <h3 style="color: #10b981;">{{ round($totalProgress ?? 0) }}%</h3>
                <p>प्रगति</p>
            </div>
            <div class="stat-item">
                <h3 style="color: #8b5cf6;">{{ isset($recentActivities) ? $recentActivities->count() : 0 }}</h3>
                <p>चैलेंज</p>
            </div>
        </div>
        
        <div style="padding: 0 20px 20px;">
            <div style="display: flex; justify-content: space-between; font-size: 11px; color: var(--text-gray); margin-bottom: 5px;">
                <span>Current Level</span>
                <span>Next Level</span>
            </div>
            <div style="height: 6px; background: #f3f4f6; border-radius: 10px; overflow: hidden;">
                <div style="width: {{ $totalProgress ?? 0 }}%; height: 100%; background: var(--insta-gradient); border-radius: 10px;"></div>
            </div>
        </div>
    </div>

    <div class="fade-in-up" style="padding: 0 20px 20px; animation-delay: 0.4s;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="font-size: 16px; font-weight: 800; color: var(--text-dark); margin: 0;">उपलब्धियां (Badges)</h3>
            <span style="font-size: 12px; color: #db2777; font-weight: 600;">सभी देखें</span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
            <div class="achievement-badge">
                <div class="badge-icon" style="background: #fff1f2; color: #be123c;">
                    <i class="fas fa-fire"></i>
                </div>
                <h4 style="font-size: 13px; font-weight: 700; color: var(--text-dark); margin: 0;">Streak Master</h4>
                <p style="font-size: 10px; color: var(--text-gray);">7 Days Login</p>
            </div>
            
            <div class="achievement-badge">
                <div class="badge-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h4 style="font-size: 13px; font-weight: 700; color: var(--text-dark); margin: 0;">Scholar</h4>
                <p style="font-size: 10px; color: var(--text-gray);">Course Complete</p>
            </div>
        </div>
    </div>

    @if(isset($recentActivities) && $recentActivities->count() > 0)
    <div class="fade-in-up" style="padding: 0 20px 20px; animation-delay: 0.5s;">
        <h3 style="font-size: 16px; font-weight: 800; color: var(--text-dark); margin-bottom: 15px;">हाल की गतिविधियां</h3>
        
        @foreach($recentActivities as $activity)
        <div class="modern-card" style="display: flex; align-items: center; padding: 15px; margin-bottom: 10px; border-radius: 16px;">
            <div style="width: 40px; height: 40px; background: #ecfdf5; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 18px; margin-right: 15px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div style="flex: 1;">
                <h4 style="font-size: 14px; font-weight: 700; color: var(--text-dark); margin: 0;">{{ $activity->challenge->title_hindi }}</h4>
                <p style="font-size: 11px; color: var(--text-gray); margin-top: 2px;">{{ $activity->completed_at->diffForHumans() }}</p>
            </div>
            <span style="font-size: 12px; font-weight: 700; color: #d97706;">+{{ $activity->points_earned }}</span>
        </div>
        @endforeach
    </div>
    @endif

    <div class="fade-in-up" style="padding: 0 20px 20px; animation-delay: 0.6s;">
        <div class="modern-card" style="padding: 25px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <div style="width: 35px; height: 35px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-dark);">
                    <i class="fas fa-cog"></i>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-dark); margin: 0;">सेटिंग्स</h3>
            </div>

            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 15px;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-gray); display: block; margin-bottom: 6px; margin-left: 4px;">Display Name</label>
                    <div style="position: relative;">
                        <i class="fas fa-user absolute" style="left: 15px; top: 14px; color: #9ca3af;"></i>
                        <input type="text" name="display_name" value="{{ $profile->display_name ?? '' }}" class="custom-input" style="padding-left: 40px;" placeholder="Enter your name">
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="font-size: 12px; font-weight: 600; color: var(--text-gray); display: block; margin-bottom: 6px; margin-left: 4px;">Language</label>
                    <div style="position: relative;">
                        <i class="fas fa-globe absolute" style="left: 15px; top: 14px; color: #9ca3af;"></i>
                        <select name="language_preference" class="custom-input" style="padding-left: 40px; appearance: none;">
                            <option value="hi" {{ ($profile->language_preference ?? 'hi') === 'hi' ? 'selected' : '' }}>🇮🇳 Hindi (हिंदी)</option>
                            <option value="en" {{ ($profile->language_preference ?? 'hi') === 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                        </select>
                        <i class="fas fa-chevron-down absolute" style="right: 15px; top: 14px; color: #9ca3af; font-size: 12px;"></i>
                    </div>
                </div>

                <button type="submit" class="action-btn">
                    सेटिंग्स अपडेट करें
                </button>
            </form>
        </div>
    </div>

</div>

@endsection