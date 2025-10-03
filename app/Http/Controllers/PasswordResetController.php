<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class PasswordResetController extends Controller
{
    public function requestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendToken(Request $request)
    {
        $data = $request->validate(['email'=>'required|email|exists:users,email']);
        $status = Password::sendResetLink(['email'=>$data['email']]);
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token'=>$token]);
    }

    public function reset(Request $request)
    {
        $data = $request->validate(['email'=>'required|email','token'=>'required','password'=>'required|confirmed|min:6']);
        $status = Password::reset(
            $data,
            function (User $user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
