@extends('layouts.app')

@section('header')
    लक्ष्य (पब्लिक)
@endsection

@section('content')
    <div class="card">
        <strong>लॉगिन करें</strong>
        <p class="small">आपको अपनी प्रगति सेव करने और अधिक फीचर एक्सेस करने के लिए लॉगिन करना होगा।</p>
        <a href="{{ route('login') }}" class="btn" style="margin-top:8px;">लॉगिन करें</a>
    </div>

    <div style="margin-top:24px;">
        <h3>उपलब्ध लक्ष्य</h3>
        @foreach($goals as $goal)
            <div class="card" style="margin-top:12px;">
                <div class="pill">{{ $goal->title_hindi }}</div>
                <p class="small">{{ $goal->description_hindi }}</p>
                <div class="progress">
                    <div class="progress-inner" style="width: {{ $goal->default_progress }}%;"></div>
                </div>
                <p class="small">{{ $goal->default_progress }}% पूर्ण</p>
            </div>
        @endforeach
    </div>
@endsection
