<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Đăng nhập lại người dùng sau khi xác minh email
     */
    protected function verified(Request $request)
    {
        $user = $request->user();

        if (is_null($user->email_verified_at)) {
            $user->markEmailAsVerified(); // Cập nhật email_verified_at
        }

        Auth::login($user); // Đăng nhập lại
        return redirect()->route('home')->with('success', 'Email của bạn đã được xác minh!');
    }
}
