<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\SysLogCapture;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    use SysLogCapture;
    public function profile(): View
    {
        return \view('profile.user-profile', ['title' => 'User Profile']);
    }
    /**
     * update password user
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user =  Auth::user();
        //has check old password
        if (!Hash::check($request->old_password, $user->password)) {
            $this->captureLog([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $user->email . ' failed update password',
                'status' => 'failed',
                'info' => "['user info']",
            ]);
            return \response()->json(['success' => false, 'data' => 'old password does not match'], 403);
        }

        try {
            //update password
            $updatePassword = User::where('id', $user->id);
            $updatePassword->update([
                'password' => Hash::make($request->new_password),
            ]);
            $this->captureLog([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $user->email . ' success update password',
                'status' => 'success',
                'info' => "['user info']",
            ]);
            return \response()->json(['success' => true, 'message' => 'update password success'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user->id ? $user->id : null,
                'email' => $user->email ? $user->email : \null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'error update password',
                'status' => 'failed',
                'info' => "['system']",
            ]);
            return \response()->json(['success' => false, 'message' => 'error, please try again'], 500);
        }
    }
    /**
     * update email
     */
    public function updateEmail(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'new_email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $updateEmail = User::where('id', $user->id);
            $updateEmail->update([
                'email' => $request->new_email,
            ]);
            $this->captureLog([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $user->email . ' success update email',
                'status' => 'success',
                'info' => "['user info']",
            ]);
            return \response()->json(['success' => true, 'message' => 'update email success'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user->id ? $user->id : null,
                'email' => $user->email ? $user->email : \null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'error change email',
                'status' => 'failed',
                'info' => "['system']",
            ]);
            return \response()->json(['success' => false, 'message' => 'error, please try again'], 500);
        }
    }
    /**
     * update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        try {
            $updateEmail = User::where('id', $user->id);
            $updateEmail->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);
            $this->captureLog([
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => $user->email . ' success update profile',
                'status' => 'success',
                'info' => "['user info']",
            ]);
            return \response()->json(['success' => true, 'message' => 'update profile success'], 200);
        } catch (\Throwable $th) {
            $this->captureLog([
                'user_id' => $user->id ? $user->id : null,
                'email' => $user->email ? $user->email : \null,
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'message' => 'error update profile',
                'status' => 'failed',
                'info' => "['system']",
            ]);
            return \response()->json(['success' => false, 'message' => 'error, please try again'], 500);
        }
    }
}
