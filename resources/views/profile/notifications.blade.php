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
                <i class="fas fa-bell text-white" style="font-size: 20px;"></i>
            </div>
            <div>
                <h1 style="font-size: 22px; font-weight: 700; margin: 0; color: white;">सूचनाएं</h1>
                <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin: 3px 0 0;">अपनी गतिविधियों और अपडेट देखें</p>
            </div>
    </div>

    <div style="background: rgba(30, 27, 75, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 24px; margin-bottom: 24px;">
        <h2 style="font-size: 16px; font-weight: 600; color: white; margin-bottom: 15px;">सूचना सेटिंग्स</h2>
        
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-bullseye" style="color: #ea580c;"></i>
                    <span style="color: white; font-size: 14px;">लक्ष्य अपडेट</span>
                </div>
                <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                    <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #22c55e; transition: .4s; border-radius: 24px; before:content: ''; before:position: absolute; before:h-[18px]; before:w-[18px]; before:left-[22px]; before:bottom-[3px]; before:bg-white; before:transition: .4s; before:border-radius: 50%;"></span>
                </label>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: rgba(255,255,255,0.05); border-radius: 10px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-fire" style="color: #f97316;"></i>
                    <span style="color: white; font-size: 14px;">चैलेंज अपडेट</span>
                </div>
                <label style="position: relative; display: inline-block; width: 44px; height: 24px;">
                    <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #22c55e; transition: .4s; border-radius: 24px;"></span>
                </label>
            </div>
    </div>

    <div style="background: rgba(30, 27, 75, 0.4); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; padding: 24px;">
        <h2 style="font-size: 16px; font-weight: 600; color: white; margin-bottom: 15px;">हाल की सूचनाएं</h2>
        
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; gap: 12px; padding: 12px; background: rgba(234, 88, 12, 0.1); border-radius: 10px; border-left: 3px solid #ea580c;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ea580c, #f97316); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-trophy text-white" style="font-size: 16px;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="color: white; font-size: 13px; margin: 0; font-weight: 500;">बधाई हो! आपने चैलेंज पूरा किया</p>
                    <p style="color: rgba(255,255,255,0.5); font-size: 11px; margin: 4px 0 0;">2 घंटे पहले</p>
                </div>
        </div>
</div>
@endsection
