@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body { background-color: #0f172a; color: white; }
    .message-bubble-sent {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 18px 18px 4px 18px;
    }
    .message-bubble-received {
        background: #1e293b;
        border-radius: 18px 18px 18px 4px;
    }
</style>

<div class="min-h-screen bg-slate-900 flex flex-col">
    
    <!-- Header -->
    <div class="bg-slate-800 p-4 flex items-center justify-between border-b border-white/10">
        <a href="{{ route('social.index') }}" class="text-white hover:text-slate-300">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-lg font-bold">Messages</h1>
        <button class="text-white">
            <i class="fas fa-edit text-xl"></i>
        </button>
    </div>

    <!-- Search -->
    <div class="p-4 border-b border-white/10">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Search messages" class="w-full bg-slate-800 border border-white/10 rounded-xl py-2 pl-10 pr-4 text-white text-sm focus:outline-none focus:border-blue-500">
        </div>
    </div>

    <!-- Messages List -->
    <div class="flex-1 overflow-y-auto">
        @if(!empty($users))
            @foreach($users as $user)
            <a href="{{ route('social.chat', $user['id']) }}" class="flex items-center gap-4 p-4 hover:bg-slate-800/50 border-b border-white/5 transition-colors">
                <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-700 flex-shrink-0">
                    @if(isset($user['avatar']))
                        <img src="{{ $user['avatar'] }}" alt="{{ $user['full_name'] }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-user text-slate-400"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-white truncate">{{ $user['full_name'] }}</h3>
                        <span class="text-xs text-slate-500">{{ date('H:i') }}</span>
                    </div>
                    <p class="text-sm text-slate-400 truncate">{{ $user['bio'] ?? 'Start a conversation' }}</p>
                </div>
            </a>
            @endforeach
        @else
            <div class="text-center py-12">
                <i class="fas fa-comments text-5xl text-slate-600 mb-4"></i>
                <p class="text-slate-400">No messages yet</p>
                <p class="text-xs text-slate-500 mt-2">Connect with friends to start chatting!</p>
            </div>
        @endif
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

