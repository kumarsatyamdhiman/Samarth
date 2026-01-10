@extends('layouts.app')

@section('content')
    <div class="insta-screen">
        <!-- Instagram-Style Header -->
        <header class="insta-header">
            <div>
                <h1 class="text-gradient">SAMARTH</h1>
                <div class="user-greeting">आपका सपना, आपका रास्ता</div>
            </div>
            <div class="insta-nav-icons" style="display: flex; gap: 16px;">
                <i class="fas fa-moon" style="color: var(--medium-gray); font-size: 20px; cursor: pointer;"></i>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="insta-main">
            @if(session('success'))
                <div class="insta-alert insta-alert-success fade-in">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="insta-alert insta-alert-error fade-in">
                    <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="insta-alert insta-alert-error fade-in">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Welcome Section -->
            <div style="padding: 32px 20px 24px; text-align: center;">
                <div class="insta-card" style="margin: 0; background: var(--insta-gradient); color: white; border: none;">
                    <div style="padding: 24px;">
                        <h2 style="margin: 0 0 12px 0; font-size: 24px; font-weight: 700;">स्वागत है</h2>
                        <p style="margin: 0; font-size: 14px; line-height: 1.5; opacity: 0.9;">
                            यह प्लेटफ़ॉर्म युवाओं को पढ़ाई और करियर चुनने के लिए प्रेरित करता है, ताकि वे बाल विवाह जैसी कुप्रथाओं से दूर रहें।
                        </p>
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <div class="insta-card" style="margin: 0 16px;">
                <div class="insta-form">
                    <form method="post" action="{{ route('login.submit') }}">
                        @csrf
                        
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div class="insta-avatar" style="width: 80px; height: 80px; margin: 0 auto 16px; background: var(--insta-gradient);">
                                <i class="fas fa-user" style="font-size: 32px; color: white;"></i>
                            </div>
                            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--dark-gray);">लॉगिन करें</h3>
                        </div>

                        <div class="insta-label">यूज़रनेम</div>
                        <input type="text" name="username" value="{{ old('username') }}" class="insta-input" placeholder="अपना यूज़रनेम डालें" required>
                        
                        <div class="insta-label">पासवर्ड</div>
                        <input type="password" name="password" class="insta-input" placeholder="अपना पासवर्ड डालें" required>
                        
                        <button type="submit" class="insta-btn insta-btn-primary" style="width: 100%; margin-top: 8px;">
                            <i class="fas fa-sign-in-alt"></i>
                            शुरू करें
                        </button>
                    </form>



                    <!-- Guest Access -->
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="{{ route('public.goals') }}" class="insta-btn insta-btn-ghost" style="text-decoration: none; width: 100%;">
                            <i class="fas fa-eye"></i>
                            लॉगिन बिना आगे बढ़ें
                        </a>
                    </div>

                    <!-- Registration Link -->
                    <div style="text-align: center; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--light-gray);">
                        <p style="margin: 0; font-size: 14px; color: var(--medium-gray);">
                            खाता नहीं है? 
                            <a href="{{ route('register.show') }}" style="color: var(--insta-blue); font-weight: 600; text-decoration: none;">यहाँ रजिस्टर करें</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Social Login Options -->
            <div style="padding: 24px 20px;">
                <div style="text-align: center; margin-bottom: 16px;">
                    <span style="color: var(--medium-gray); font-size: 14px;">या इनसे लॉगिन करें</span>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button class="insta-btn insta-btn-secondary" style="flex: 1; background: #1877f2; color: white; border: none;">
                        <i class="fab fa-facebook"></i>
                        Facebook
                    </button>
                    <button class="insta-btn insta-btn-secondary" style="flex: 1; background: #ea4335; color: white; border: none;">
                        <i class="fab fa-google"></i>
                        Google
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div style="text-align: center; padding: 24px 20px; color: var(--medium-gray); font-size: 12px;">
                <p style="margin: 0; line-height: 1.5;">
                    लॉगिन करके आप हमारी 
                    <a href="#" style="color: var(--insta-blue); text-decoration: none;">Terms of Service</a> 
                    और 
                    <a href="#" style="color: var(--insta-blue); text-decoration: none;">Privacy Policy</a> 
                    को स्वीकार करते हैं।
                </p>
            </div>
        </main>
    </div>

    <!-- Additional Instagram-style styling -->
    <style>
        .insta-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--insta-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
        }

        .insta-input::placeholder {
            color: var(--medium-gray);
            font-size: 14px;
        }

        .insta-btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        code {
            background: var(--ultra-light-gray);
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 11px;
            color: var(--dark-gray);
        }

        /* Responsive adjustments */
        @media (max-width: 420px) {
            .insta-screen {
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
@endsection
