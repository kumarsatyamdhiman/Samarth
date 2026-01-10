<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\SamarthUser;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:samarth_users,username',
            'email' => 'required|string|email|max:255|unique:samarth_users,email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'required|string|in:male,female,other,prefer_not_to_say',
            'date_of_birth' => 'required|date|before:today',
            'password' => 'required|string|min:6|confirmed',
            'is_terms_accepted' => 'required|accepted',
        ], [
            'first_name.required' => 'पहला नाम आवश्यक है',
            'last_name.required' => 'उपनाम आवश्यक है',
            'username.required' => 'यूज़रनेम आवश्यक है',
            'username.unique' => 'यह यूज़रनेम पहले से उपयोग में है',
            'email.required' => 'ईमेल आवश्यक है',
            'email.email' => 'कृपया सही ईमेल दर्ज करें',
            'email.unique' => 'यह ईमेल पहले से रजिस्टर है',
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

        $user = SamarthUser::create([
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

        Auth::login($user);

        return redirect()->route('home')->with('success', 'स्वागत है ' . $user->first_name . '! आपका खाता सफलतापूर्वक बन गया है।');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Find user in database
        $user = SamarthUser::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/home')->with('success', 'स्वागत है ' . $user->first_name . '!');
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
}
