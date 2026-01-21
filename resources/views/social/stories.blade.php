@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body { background-color: #0f172a; color: white; }
    .story-ring {
        background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        padding: 3px;
        border-radius: 50%;
    }
    .story-seen {
        border: 2px solid #64748b;
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="min-h-screen bg-slate-900 flex flex-col">
    
    <!-- Header -->
    <div class="bg-slate-800 p-4 flex items-center justify-between border-b border-white/10">
        <a href="{{ route('social.index') }}" class="text-white hover:text-slate-300">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-lg font-bold">Stories</h1>
        <button class="text-white">
            <i class="fas fa-plus-circle text-xl"></i>
        </button>
    </div>

    <!-- Stories Grid -->
    <div class="flex-1 overflow-y-auto p-4">
        <!-- My Story -->
        <div class="mb-6">
            <div class="story-ring w-20 h-20 flex items-center justify-center cursor-pointer">
                <div class="w-full h-full rounded-full bg-slate-700 flex items-center justify-center overflow-hidden relative">
                    @if($currentUser && isset($currentUser['avatar']))
                        <img src="{{ $currentUser['avatar'] }}" alt="Your story" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-plus text-2xl text-slate-400"></i>
                    @endif
                    <div class="absolute bottom-0 right-0 bg-blue-500 w-6 h-6 rounded-full flex items-center justify-center border-2 border-slate-900">
                        <i class="fas fa-plus text-xs text-white"></i>
                    </div>
                </div>
            </div>
            <p class="text-center text-xs mt-2 text-slate-400">Your Story</p>
        </div>

        <!-- All Stories -->
        <div class="space-y-4">
            @foreach($stories as $story)
            <div class="flex items-center gap-4 p-2 rounded-lg hover:bg-slate-800/50 cursor-pointer">
                <div class="story-ring w-16 h-16 flex items-center justify-center flex-shrink-0">
                    <div class="w-full h-full rounded-full bg-slate-800 overflow-hidden {{ $story['seen'] ? 'story-seen' : '' }}">
                        @if(isset($story['user']['avatar']))
                            <img src="{{ $story['user']['avatar'] }}" alt="{{ $story['user']['full_name'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-700">
                                <i class="fas fa-user text-slate-400"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-white truncate">{{ $story['user']['full_name'] ?? 'Unknown' }}</h3>
                    <p class="text-xs text-slate-400">{{ $story['seen'] ? 'Viewed' : 'New' }} • {{ $story['created_at'] ?? 'Just now' }}</p>
                </div>
                <div class="text-slate-400 text-xs">
                    {{ date('H:i', strtotime($story['created_at'] ?? 'now')) }}
                </div>
            </div>
            @endforeach

            @if(empty($stories))
            <div class="text-center py-8">
                <i class="fas fa-photo-video text-4xl text-slate-600 mb-4"></i>
                <p class="text-slate-400">No stories yet</p>
                <p class="text-xs text-slate-500 mt-2">Be the first to share!</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="bg-slate-800 border-t border-white/10 p-3">
        <div class="flex justify-around">
            <a href="{{ route('home') }}" class="text-slate-400 flex flex-col items-center">
                <i class="fas fa-home text-xl"></i>
                <span class="text-[10px] mt-1">Home</span>
            </a>
            <a href="{{ route('social.index') }}" class="text-blue-400 flex flex-col items-center">
                <i class="fas fa-user-friends text-xl"></i>
                <span class="text-[10px] mt-1">Social</span>
            </a>
            <a href="{{ route('education.index') }}" class="text-slate-400 flex flex-col items-center">
                <i class="fas fa-graduation-cap text-xl"></i>
                <span class="text-[10px] mt-1">Learn</span>
            </a>
            <a href="{{ route('profile.show') }}" class="text-slate-400 flex flex-col items-center">
                <i class="fas fa-user text-xl"></i>
                <span class="text-[10px] mt-1">Profile</span>
            </a>
        </div>
    </div>
</div>

@endsection

