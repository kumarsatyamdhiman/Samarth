@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-6">
    <!-- Bundelkhand Welcome Section -->
    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2" style="font-family: 'Noto Serif Devanagari', serif;">
            बुंदेलखंड
        </h1>
        <p class="text-slate-400 text-lg">किसान जीवन और समृद्धि का प्लेटफॉर्म</p>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full max-w-4xl mb-8">
        <div class="glass-card p-6 rounded-xl text-center">
            <i class="fas fa-seedling text-3xl text-earth-saffron mb-3"></i>
            <h3 class="text-white font-semibold mb-1">कृषि सहायता</h3>
            <p class="text-slate-400 text-sm">आधुनिक कृषि तकनीक और जानकारी</p>
        </div>
        <div class="glass-card p-6 rounded-xl text-center">
            <i class="fas fa-graduation-cap text-3xl text-earth-saffron mb-3"></i>
            <h3 class="text-white font-semibold mb-1">शिक्षा</h3>
            <p class="text-slate-400 text-sm">गुणवत्तापूर्ण शिक्षा और करियर मार्गदर्शन</p>
        </div>
        <div class="glass-card p-6 rounded-xl text-center">
            <i class="fas fa-users text-3xl text-earth-saffron mb-3"></i>
            <h3 class="text-white font-semibold mb-1">सामुदायिक</h3>
            <p class="text-slate-400 text-sm">एकजुट समुदाय और साझा विकास</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('login') }}" class="btn-primary px-8 py-3 rounded-xl text-white font-semibold text-center">
            लॉगिन करें
        </a>
        <a href="{{ route('register') }}" class="btn-outline px-8 py-3 rounded-xl text-white font-semibold text-center border border-white/20">
            रजिस्टर करें
        </a>
    </div>

    <!-- Features -->
    <div class="mt-12 w-full max-w-2xl">
        <h2 class="text-xl font-bold text-white text-center mb-6">हमारी सेवाएं</h2>
        <div class="space-y-3">
            <div class="flex items-center gap-3 glass-card p-4 rounded-xl">
                <i class="fas fa-check-circle text-green-400"></i>
                <span class="text-slate-300">मुफ्त शैक्षिक सामग्री और वीडियो</span>
            </div>
            <div class="flex items-center gap-3 glass-card p-4 rounded-xl">
                <i class="fas fa-check-circle text-green-400"></i>
                <span class="text-slate-300">किसानों के लिए चैलेंज और पुरस्कार</span>
            </div>
            <div class="flex items-center gap-3 glass-card p-4 rounded-xl">
                <i class="fas fa-check-circle text-green-400"></i>
                <span class="text-slate-300">सामाजिक नेटवर्किंग और अनुभव साझा करना</span>
            </div>
        </div>
    </div>
</div>
@endsection

