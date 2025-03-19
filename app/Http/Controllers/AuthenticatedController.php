<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\SysLogCapture;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedController extends Controller
{
    use SysLogCapture;
    public function login()
    {
        return view('auth.login');
    }

    public function processedLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 1])) {
            $request->session()->regenerate();
            //create log
            $auth = Auth::user();
            $this->captureLog([
                'user_id' => $auth ? $auth->id : null,
                'email' => $email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $email . ' login to system',
                'status' => 'success',
                'info' => "['user info', 'system']",
            ]);

            return \response()->json(['success' => true, 'url' => \route('dashboard')], 200);
        } else {
            $this->captureLog([
                'user_id' => null,
                'email' => $email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $email . ' failed login to system',
                'status' => 'failed',
                'info' => "['user info', 'system']",
            ]);

            return \response()->json(['success' => false], 403);
        }
    }

    public function logout(Request $request)
    {
        $this->captureLog([
            'user_id' => Auth::user() ? Auth::user()->id : null,
            'email' => Auth::user() ? Auth::user()->email : null,
            'ip' => $request->ip(),
            'agent' => $request->header('user-agent'),
            'message' => Auth::user()->email . ' logout from system',
            'status' => 'success',
            'info' => "['user info', 'system']",
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $url = \url('/login');

        return \response()->json(['success' => \true, 'url' => $url], 200);
    }
    /**
     * handle view forgot password
     */
    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }
    /**
     * handle view success forgot password
     */
    public function forgotPasswordSuccess(): View
    {
        return view('auth.success');
    }
}
