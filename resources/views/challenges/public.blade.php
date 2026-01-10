@extends('layouts.app')

@section('header')
    चैलेंज (पब्लिक)
@endsection

@section('content')
    <div class="card">
        <strong>लॉगिन करें</strong>
        <p class="small">अपनी प्रगति सेव करने और चैलेंज पूरे करने के लिए लॉगिन करें।</p>
        <a href="{{ route('login') }}" class="btn" style="margin-top:8px;">लॉगिन करें</a>
    </div>

    <div style="margin-top:24px;">
        <h3>उपलब्ध चैलेंज</h3>
        @foreach($challenges as $challenge)
            <div class="card" style="margin-top:12px;">
                <div class="pill">{{ $challenge->category }}</div>
                <strong>{{ $challenge->title_hindi }}</strong>
                <p class="small">{{ $challenge->description_hindi }}</p>
                <p class="small">अनुमानित समय: {{ $challenge->estimated_time_minutes }} मिनट</p>
                <p class="small">अंक: {{ $challenge->points_reward }}</p>
            </div>
        @endforeach
    </div>
@endsection
