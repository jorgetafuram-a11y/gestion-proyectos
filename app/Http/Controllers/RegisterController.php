<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
            'student_id'=>'nullable|exists:students,id'
        ]);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        Auth::login($user);
        return redirect('/');
    }
}
