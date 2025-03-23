<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\SysLogCapture;
use App\Models\PasswordsReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SendForgotPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;

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
    /**
     * process forgot password
     */
    public function processForgotPassword(Request $request): RedirectResponse
    {
        $email = $request->email;
        $expiredAt = Carbon::now()->addMinutes(10);
        try {
            DB::beginTransaction();
            $token = date('mds') . Str::random(30) . time();
            //create password token
            $passwordToken = PasswordsReset::create([
                'email' => $email,
                'token' => $token,
                'expired_at' => $expiredAt,
            ]);
            DB::commit();
            //create log
            $this->captureLog([
                'user_id' => null,
                'email' => $email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $email . ' request forgot password',
                'status' => 'success',
                'info' => "['user info', 'system']",
            ]);
            $data = [
                'email' => $email,
                'token' => \route('change_password', ['token' => $passwordToken->token]),
            ];
            //send mail
            Notification::route('mail', [
                $email => $email,
            ])->notify(new SendForgotPassword($data));

            return \redirect()->route('forgot_password_check_email');
        } catch (\Throwable $th) {
            DB::rollBack();
            //create log
            $this->captureLog([
                'user_id' => null,
                'email' => $email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $email . ' failed request forgot password, error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']",
            ]);

            return \abort(500, 'Internal server error');
        }
    }
    /**
     * handle view success send email reset password
     */
    public function checkEmail(): View
    {
        return view('auth.check-email');
    }
    /**
     * check token when user click link from email
     */
    public function checkToken($token): View
    {
        $passwordToken = PasswordsReset::where('token', $token)->firstOrFail();
        if (1 == $passwordToken->is_used) {
            return \abort(419, 'token not valid');
        }

        if (Carbon::parse($passwordToken->expired_at) < Carbon::now()) {
            return \abort(419, 'token expired');
        }
        return view('auth.change-password', ['token' => $token]);
    }
    /**
     * process change password
     */
    public function processingChangePassword(Request $request, $token): RedirectResponse
    {
        $passwordToken = PasswordsReset::where('token', $token)->firstOrFail();
        if (1 == $passwordToken->is_used) {
            return \abort(419, 'token not valid');
        }

        if (Carbon::parse($passwordToken->expired_at) < Carbon::now()) {
            return \abort(419, 'token expired');
        }

        $request->validate([
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        try {
            $passwordToken->is_used = 1;
            $passwordToken->save();

            $user = User::where('email', $passwordToken->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            $this->captureLog([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $user->email . ' success update password',
                'status' => 'success',
                'info' => "['user info', 'system']",
            ]);

            return \redirect()->route('forgot_password_success');
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => null,
                'email' => $passwordToken->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $passwordToken->email . ' failed change forgot password, error: ' . $th->getMessage(),
                'status' => 'failed',
                'info' => "['system']",
            ]);

            return \abort(500, 'Internal server error');
        }
    }
}
