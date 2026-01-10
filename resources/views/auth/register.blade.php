@extends('layouts.app')

@section('content')
    <div class="insta-screen">
        <!-- Instagram-Style Header -->
        <header class="insta-header">
            <div>
                <h1 class="text-gradient">SAMARTH</h1>
                <div class="user-greeting">आपका सपना, आपका रास्ता</div>
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

            <!-- Registration Form -->
            <div class="insta-card" style="margin: 16px;">
                <div class="insta-form">
                    <form method="post" action="{{ route('register.submit') }}">
                        @csrf
                        
                        <div style="text-align: center; margin-bottom: 24px;">
                            <div class="insta-avatar" style="width: 80px; height: 80px; margin: 0 auto 16px; background: var(--insta-gradient);">
                                <i class="fas fa-user-plus" style="font-size: 32px; color: white;"></i>
                            </div>
                            <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--dark-gray);">नया खाता बनाएं</h3>
                            <p style="margin: 8px 0 0; font-size: 12px; color: var(--medium-gray);">सभी फ़ील्ड भरना अनिवार्य है *</p>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                            <div>
                                <div class="insta-label">पहला नाम *</div>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="insta-input" placeholder="राम" required>
                            </div>
                            <div>
                                <div class="insta-label">उपनाम *</div>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="insta-input" placeholder="शर्मा" required>
                            </div>
                        </div>

                        <div class="insta-label">यूज़रनेम *</div>
                        <input type="text" name="username" value="{{ old('username') }}" class="insta-input" placeholder="ram_sharma123" required>
                        
                        <div class="insta-label">ईमेल *</div>
                        <input type="email" name="email" value="{{ old('email') }}" class="insta-input" placeholder="ram@email.com" required>
                        
                        <div class="insta-label">मोबाइल नंबर</div>
                        <input type="tel" name="phone" value="{{ old('phone') }}" class="insta-input" placeholder="9876543210">
                        
                        <div class="insta-label">लिंग *</div>
                        <select name="gender" class="insta-input" required>
                            <option value="">चुनें...</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>पुरुष</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>महिला</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>अन्य</option>
                            <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>बताना नहीं चाहते</option>
                        </select>

                        <div class="insta-label">जन्म तिथि *</div>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="insta-input" required>
                        
                        <div class="insta-label">पासवर्ड *</div>
                        <input type="password" name="password" class="insta-input" placeholder="कम से कम 6 अक्षर" required minlength="6">
                        
                        <div class="insta-label">पासवर्ड की पुष्टि करें *</div>
                        <input type="password" name="password_confirmation" class="insta-input" placeholder="पासवर्ड दोबारा डालें" required>
                        
                        <div style="margin: 16px 0;">
                            <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="is_terms_accepted" value="1" required style="margin-top: 3px; accent-color: var(--insta-blue);">
                                <span style="font-size: 11px; color: var(--medium-gray); line-height: 1.4;">
                                    मैं <a href="#" style="color: var(--insta-blue);">Terms of Service</a> और <a href="#" style="color: var(--insta-blue);">Privacy Policy</a> पढ़कर स्वीकार करता/करती हूं *
                                </span>
                            </label>
                        </div>
                        
                        <button type="submit" class="insta-btn insta-btn-primary" style="width: 100%; margin-top: 8px;">
                            <i class="fas fa-user-plus"></i>
                            खाता बनाएं
                        </button>
                    </form>

                    <!-- Login Link -->
                    <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--light-gray);">
                        <p style="margin: 0; font-size: 14px; color: var(--medium-gray);">
                            पहले से खाता है? 
                            <a href="{{ route('login.show') }}" style="color: var(--insta-blue); font-weight: 600; text-decoration: none;">यहाँ लॉगिन करें</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="text-align: center; padding: 24px 20px; color: var(--medium-gray); font-size: 12px;">
                <p style="margin: 0; line-height: 1.5;">
                    रजिस्टर करके आप हमारी 
                    <a href="#" style="color: var(--insta-blue); text-decoration: none;">Terms of Service</a> 
                    और 
                    <a href="#" style="color: var(--insta-blue); text-decoration: none;">Privacy Policy</a> 
                    को स्वीकार करते हैं।
                </p>
            </div>
        </main>
    </div>

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

        .insta-input {
            font-size: 14px;
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

