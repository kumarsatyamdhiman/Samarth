@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body { background-color: #0f172a; color: white; }
    .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
</style>

<div class="min-h-screen bg-slate-900">
    
    <!-- Header -->
    <div class="sticky top-0 bg-slate-900/95 backdrop-blur-sm p-4 flex items-center justify-between border-b border-white/10 z-10">
        <a href="{{ route('social.index') }}" class="text-white hover:text-slate-300">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-lg font-bold">Explore</h1>
        <button class="text-white">
            <i class="fas fa-search text-xl"></i>
        </button>
    </div>

    <!-- Hashtags/Topics -->
    <div class="p-4 border-b border-white/10 overflow-x-auto whitespace-nowrap">
        <div class="flex gap-2">
            <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap">All</span>
            <span class="bg-slate-800 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap border border-white/10">Study</span>
            <span class="bg-slate-800 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap border border-white/10">JEE</span>
            <span class="bg-slate-800 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap border border-white/10">NEET</span>
            <span class="bg-slate-800 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap border border-white/10">Coding</span>
            <span class="bg-slate-800 text-white px-4 py-1 rounded-full text-sm whitespace-nowrap border border-white/10">Sports</span>
        </div>
    </div>

    <!-- Posts Grid -->
    <div class="p-1">
        <div class="grid grid-cols-3 gap-1">
            @if(!empty($posts))
                @foreach($posts as $post)
                <div class="aspect-square bg-slate-800 overflow-hidden cursor-pointer relative group">
                    @if(isset($post['image_url']))
                        <img src="{{ $post['image_url'] }}" alt="Post" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-image text-slate-600 text-3xl"></i>
                        </div>
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <div class="flex items-center gap-4 text-white">
                            <span class="flex items-center gap-1">
                                <i class="fas fa-heart"></i> {{ $post['likes'] ?? 0 }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fas fa-comment"></i> {{ $post['comments'] ?? 0 }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                @for($i = 0; $i < 9; $i++)
                <div class="aspect-square bg-slate-800 overflow-hidden cursor-pointer relative">
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-slate-600 text-2xl"></i>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>

    <!-- Loading indicator -->
    <div class="p-4 text-center">
        <div class="inline-flex items-center gap-2 text-slate-400">
            <i class="fas fa-spinner fa-spin"></i>
            <span class="text-sm">Loading more...</span>
        </div>
    </div>
</div>

@endsection

