<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Trả về thông tin đăng nhập.
     */
    public function credentials(Request $request): array
    {
        return [
            'email' => $request->input('email', ''),
            'password' => $request->input('password', ''),
            'status' => 'active',
            'role' => 'user'
        ];
    }

    /**
     * Xử lý đăng nhập thủ công và kiểm tra xác minh email.
     */
    protected function attemptLogin(Request $request): bool
    {
        $credentials = $this->credentials($request);

        // Kiểm tra nếu thiếu email hoặc password
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return false;
        }

        // Tìm user theo email
        $user = User::where('email', $credentials['email'])->first();

        // Nếu user không tồn tại hoặc chưa xác minh email => không cho đăng nhập
        if (!$user || !$user->hasVerifiedEmail()) {
            return false;
        }

        // Đăng nhập bằng Auth::attempt() nếu thông tin hợp lệ
        return Auth::attempt(
            ['email' => $credentials['email'], 'password' => $credentials['password']],
            $request->filled('remember')
        );
    }



    /**
     * Xử lý sau khi đăng nhập thành công.
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('verification.notice')
                ->with('message', 'Bạn cần xác minh email trước khi đăng nhập.');
        }
    }


    /**
     * Xử lý đăng nhập với Socialite.
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Xử lý callback từ Socialite.
     */
    public function callback($provider)
    {
        $userSocial = Socialite::driver($provider)->user();
        $user = User::where('email', $userSocial->getEmail())->first();

        if ($user) {
            Auth::login($user);
            return redirect('/')->with('success', 'Bạn đã đăng nhập bằng ' . $provider);
        } else {
            $newUser = User::create([
                'name'        => $userSocial->getName(),
                'email'       => $userSocial->getEmail(),
                'image'       => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider'    => $provider,
            ]);
            return redirect()->route('home');
        }
    }
}
