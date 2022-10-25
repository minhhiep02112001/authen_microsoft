<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthSocialiteController
{
    protected $socialite = ['google', 'microsoft'];
    public function login($attr)
    {
        if (!in_array($attr, $this->socialite)) {
            return abort(404);
        }
        return Socialite::driver($attr)->redirect();
    }

    public function callback(Request  $request, $attr)
    {
        $url_session = $request->session()->all();

        $url = route('home');

        if (!in_array($attr, $this->socialite)) {
            return abort(404);
        }
        $user = Socialite::driver($attr)->user();

        $profile = User::where('email', $user->getEmail())->first();

        if (!empty($profile)) {
            Auth::guard('web')->loginUsingId($profile->id);
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with('notification_error', 'Hệ thống không tìm thấy tài khoản của bạn');
        }
    }
}
