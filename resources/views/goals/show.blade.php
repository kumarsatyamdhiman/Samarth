@extends('layouts.app')

@section('header')
    {{ $goal->title_hindi }}
@endsection

@section('content')
    <div class="card">
        <div class="pill">{{ $goal->title_hindi }}</div>
        <p>{{ $goal->description_hindi }}</p>
    </div>

    <div style="margin-top:24px;">
        <h3>लक्ष्य के कदम</h3>
        <ul class="small">
            @foreach($goal->steps_hindi as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ul>
    </div>

    <div style="margin-top:24px;">
        <h3>आपकी प्रगति</h3>
        <div class="progress">
            <div class="progress-inner" style="width: {{ $userProgress->progress_percentage }}%;"></div>
        </div>
        <p class="small">{{ $userProgress->progress_percentage }}% पूर्ण</p>
        
        <form method="post" action="{{ route('goals.progress', $goal) }}" style="margin-top:12px;">
            @csrf
            <label>प्रगति अपडेट करें (%):</label><br>
            <input type="number" name="progress" min="0" max="100" value="{{ $userProgress->progress_percentage }}" style="width:100%;padding:8px;margin:6px 0;border-radius:6px;border:1px solid #ddd;">
            <button type="submit" class="btn" style="margin-top:8px;">अपडेट करें</button>
        </form>
    </div>

    @if($goal->resources && count($goal->resources) > 0)
        <div style="margin-top:24px;">
            <h3>उपयोगी संसाधन</h3>
            @foreach($goal->resources as $resource)
                <a href="{{ $resource }}" target="_blank" class="btn btn-secondary" style="margin-top:8px;display:block;text-align:center;">
                    संसाधन देखें
                </a>
            @endforeach
        </div>
    @endif
@endsection
