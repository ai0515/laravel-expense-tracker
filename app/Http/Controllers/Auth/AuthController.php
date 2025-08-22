<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserRequest;

class AuthController extends Controller
{
        public function showLoginForm()
    {
        return view('transactions.login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email'=>$email, 'password'=>$password], false))
        {
            return redirect('/transactions');
        }

        return back()
            ->withErrors(['login' => 'メールアドレスまたはパスワードに誤りがあります。'])
            ->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/transactions/login');
    }

    public function showRegisterForm()
    {
        return view('transactions.register');
    }

    public function createUser(UserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect('/transactions')->with('success', 'ユーザー登録が完了しました。');
    }
}
