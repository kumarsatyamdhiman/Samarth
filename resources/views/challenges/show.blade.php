@extends('layouts.app')

@section('header')
    {{ $challenge->title_hindi }}
@endsection

@section('content')
    <div class="card">
        <div class="pill">{{ $challenge->category }}</div>
        <strong>{{ $challenge->title_hindi }}</strong>
        <p class="small">{{ $challenge->description_hindi }}</p>
        <p class="small">अनुमानित समय: {{ $challenge->estimated_time_minutes }} मिनट</p>
        <p class="small">अंक: {{ $challenge->points_reward }}</p>
    </div>

    @if($challenge->instructions_hindi && count($challenge->instructions_hindi) > 0)
        <div style="margin-top:24px;">
            <h3>निर्देश</h3>
            <ol class="small">
                @foreach($challenge->instructions_hindi as $instruction)
                    <li>{{ $instruction }}</li>
                @endforeach
            </ol>
        </div>
    @endif

    @if($challenge->reflection_questions && count($challenge->reflection_questions) > 0)
        <div style="margin-top:24px;">
            <h3>सोचने योग्य प्रश्न</h3>
            <ul class="small">
                @foreach($challenge->reflection_questions as $question)
                    <li>{{ $question }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!$userChallenge)
        <div style="margin-top:24px;">
            <form method="post" action="{{ route('challenges.complete', $challenge) }}">
                @csrf
                <label>नोट्स (वैकल्पिक):</label><br>
                <textarea name="notes" rows="3" style="width:100%;padding:8px;margin:6px 0;border-radius:6px;border:1px solid #ddd;" placeholder="अपने अनुभव या विचार लिखें..."></textarea>
                <button type="submit" class="btn" style="margin-top:8px;">चैलेंज पूरा करें</button>
            </form>
        </div>
    @else
        <div style="margin-top:24px;">
            <div class="card" style="background:#dcfce7;border-color:#bbf7d0;">
                <strong>बधाई हो!</strong>
                <p class="small">आपने यह चैलेंज {{ $userChallenge->completed_at->format('d M, Y h:i A') }} को पूरा किया और {{ $userChallenge->points_earned }} अंक अर्जित किए।</p>
                @if($userChallenge->notes)
                    <p class="small"><strong>आपके नोट्स:</strong> {{ $userChallenge->notes }}</p>
                @endif
            </div>
        </div>
    @endif

    @if($challenge->resources && count($challenge->resources) > 0)
        <div style="margin-top:24px;">
            <h3>उपयोगी संसाधन</h3>
            @foreach($challenge->resources as $resource)
                <a href="{{ $resource }}" target="_blank" class="btn btn-secondary" style="margin-top:8px;display:block;text-align:center;">
                    संसाधन देखें
                </a>
            @endforeach
        </div>
    @endif
@endsection
