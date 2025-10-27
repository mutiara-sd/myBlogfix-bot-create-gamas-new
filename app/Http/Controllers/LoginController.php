<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function LoginForm()
    {
        return view('login.index', [
            'title' => 'Sign In',
        ]);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_src('mini')]);
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        $fieldType = User::where('username', $credentials['login'])->exists() ? 'username' : 'telegram_username';

        $user = User::where($fieldType, $credentials['login'])->first();

        if (! $user) {
            return back()->withErrors(['login' => 'Username or Telegram username not found.'])->withInput();
        }

        if (! $user->is_verified) {
            return back()->withErrors(['login' => 'Your account has not been verified by the admin.'])->withInput();
        }

        if (! \Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['login' => 'Username or Telegram Username and Password are wrong'])->withInput();
        }

        session(['pending_user_id' => $user->id]);

        session(['theme_preferences' => $user->theme_preferences]);

        $otpController = new TelegramOTPController;
        $otpController->sendOtp($request);

        return redirect('/otp');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/dashboard');
    }
}
