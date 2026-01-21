@extends('layouts.app')

@section('content')
<div class="fade-in-up" style="padding: 20px;">
    <div style="margin-bottom: 20px;">
        <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none;">
            <i class="fas fa-arrow-right fa-rotate-180" style="font-size: 18px;"></i>
            <span style="font-size: 14px;">वापस</span>
        </a>
    </div>

    <div style="background: rgba(30, 27, 75, 0.6); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 24px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ea580c, #f97316); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-cog text-white" style="font-size: 20px;"></i>
            </div>
            <div>
                <h1 style="font-size: 22px; font-weight: 700; margin: 0; color: white;">सेटिंग्स</h1>
                <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin: 3px 0 0;">अपनी प्राथमिकताएं कॉन्फ़िगर करें</p>
            </div>
    </div>

    <div style="background: rgba(30, 27, 75, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 24px; margin-bottom: 24px;">
        <h2 style="font-size: 16px; font-weight: 600; color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-user" style="color: #ea580c;"></i>
            खाता सेटिंग्स
        </h2>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 12px; margin-bottom: 6px;">प्रदर्शन नाम</label>
                <input type="text" name="display_name" value="{{ $profile->display_name ?? $user->username }}" 
                    style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 14px;">
            </div>
            
            <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #ea580c, #f97316); border: none; border-radius: 10px; color: white; font-size: 14px; font-weight: 600; cursor: pointer;">
                सहेजें
            </button>
        </form>
    </div>

    <div style="background: rgba(30, 27, 75, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 24px; margin-bottom: 24px;">
        <h2 style="font-size: 16px; font-weight: 600; color: white; margin-bottom: 15px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-language" style="color: #3b82f6;"></i>
            भाषा सेटिंग्स
        </h2>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; color: rgba(255,255,255,0.7); font-size: 12px; margin-bottom: 6px;">पसंदीदा भाषा</label>
                <select name="language_preference" style="width: 100%; padding: 12px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 10px; color: white; font-size: 14px;">
                    <option value="hi" {{ ($profile->language_preference ?? 'hi') == 'hi' ? 'selected' : '' }}>हिंदी</option>
                    <option value="en" {{ ($profile->language_preference ?? '') == 'en' ? 'selected' : '' }}>English</option>
                </select>
            </div>
            
            <button type="submit" style="width: 100%; padding: 12px; background: linear-gradient(135deg, #ea580c, #f97316); border: none; border-radius: 10px; color: white; font-size: 14px; font-weight: 600; cursor: pointer;">
                सहेजें
            </button>
        </form>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" style="width: 100%; padding: 15px; background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 16px; color: #ef4444; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <i class="fas fa-sign-out-alt"></i>
            लॉग आउट
        </button>
    </form>
</div>
@endsection
