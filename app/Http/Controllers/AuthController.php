<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Services\JsonDataStore;

class AuthController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = new JsonDataStore();
    }

    public function showLogin()
    {
        // Redirect to home if already logged in
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        // Redirect to home if already logged in
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|string|in:male,female,other,prefer_not_to_say',
            'date_of_birth' => 'required|date|before:today',
            'password' => 'required|string|min:6|confirmed',
            'is_terms_accepted' => 'required|accepted',
        ], [
            'first_name.required' => 'पहला नाम आवश्यक है',
            'last_name.required' => 'उपनाम आवश्यक है',
            'username.required' => 'यूज़रनेम आवश्यक है',
            'email.required' => 'ईमेल आवश्यक है',
            'email.email' => 'कृपया सही ईमेल दर्ज करें',
            'gender.required' => 'लिंग चुनना आवश्यक है',
            'date_of_birth.required' => 'जन्म तिथि आवश्यक है',
            'date_of_birth.before' => 'जन्म तिथि आज से पहले होनी चाहिए',
            'password.required' => 'पासवर्ड आवश्यक है',
            'password.min' => 'पासवर्ड कम से कम 6 अक्षर का होना चाहिए',
            'password.confirmed' => 'पासवर्ड मेल नहीं खाते',
            'is_terms_accepted.required' => 'आपको Terms of Service स्वीकार करनी होंगी',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Check if username or email already exists
        $existingUser = $this->users->findBy('users', 'username', $request->username);
        if ($existingUser) {
            return back()->withErrors(['username' => 'यह यूज़रनेम पहले से उपयोग में है'])->withInput();
        }

        $existingEmail = $this->users->findBy('users', 'email', $request->email);
        if ($existingEmail) {
            return back()->withErrors(['email' => 'यह ईमेल पहले से रजिस्टर है'])->withInput();
        }

        // Create new user in JSON store
        $user = $this->users->create('users', [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'active',
            'is_terms_accepted' => true,
            'is_privacy_accepted' => true,
            'timezone' => 'Asia/Kolkata',
            'language' => 'hi',
        ]);

        // Log in the user
        Auth::loginUsingId($user['id']);

        return redirect()->route('home')->with('success', 'स्वागत है ' . $user['first_name'] . '! आपका खाता सफलतापूर्वक बन गया है।');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Find user in JSON store
        $user = $this->users->findBy('users', 'username', $request->username);

        if ($user && Hash::check($request->password, $user['password'])) {
            Auth::loginUsingId($user['id']);
            $request->session()->regenerate();

            return redirect()->intended('/home')->with('success', 'स्वागत है ' . $user['first_name'] . '!');
        }

        return back()->withErrors([
            'username' => 'गलत यूज़रनेम या पासवर्ड।',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'आपने सफलतापूर्वक लॉग आउट किया है।');
    }

    /**
     * Check security question for password recovery
     */
    public function checkSecurityQuestion(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $user = $this->users->findBy('users', 'username', $request->username);
        
        if (!$user) {
            return back()->withErrors(['username' => 'यह यूज़रनेम मौजूद नहीं है।']);
        }
        
        // Get the user's security question
        $securityQuestion = $user['security_question'] ?? 'school';
        $securityAnswer = $user['security_answer'] ?? '';
        
        // Store in session for step 2
        $request->session()->put('reset_username', $user['username']);
        $request->session()->put('security_question', $securityQuestion);
        $request->session()->put('security_answer', $securityAnswer);
        
        return redirect()->route('password.recovery');
    }

    /**
     * Reset password after security question verification
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'security_answer' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $username = $request->session()->get('reset_username');
        $storedAnswer = $request->session()->get('security_answer');
        
        if (!$username || $username !== $request->username) {
            $request->session()->forget(['reset_username', 'security_question', 'security_answer']);
            return redirect()->route('password.recovery')->with('error', 'Session expired. Please try again.');
        }

        // Verify security answer
        if (strtolower(trim($storedAnswer)) !== strtolower(trim($request->security_answer))) {
            $request->session()->forget(['reset_username', 'security_question', 'security_answer']);
            return redirect()->route('password.recovery')->with('error', 'सुरक्षा प्रश्न का उत्तर गलत है।');
        }

        // Update password in JSON store
        $user = $this->users->findBy('users', 'username', $username);
        
        if ($user) {
            $this->users->update('users', $user['id'], [
                'password' => Hash::make($request->password)
            ]);
        }

        // Clear session
        $request->session()->forget(['reset_username', 'security_question', 'security_answer']);

        return redirect()->route('login')->with('success', 'पासवर्ड सफलतापूर्वक बदल दिया गया है! अब लॉगिन करें।');
    }
}

