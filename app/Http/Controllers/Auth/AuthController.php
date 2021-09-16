<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\CurrentPasswordCorrectRule;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function storeLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->remember)) {
            return redirect()->route('admin')->with('success', 'Login successfully');
        }

        return redirect()->route('login')->with('error', 'Login unsuccessfully');
    }

    public function register() {
        return "view register";
    }

    public function storeRegister()
    {
        DB::beginTransaction();
        try {
            User::create([
                'name' => 'dungvn',
                'email' => 'dungvn.dev@gmail.com',
                'password' => Hash::make('123456'),
            ]);
            DB::commit();

            return redirect()->route('login')->with('success', 'Successfully');
        } catch (\Exception $exception) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Some thing wrong!');
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new CurrentPasswordCorrectRule()],
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
            ],
            'password_confirmation' => 'required|max:255',]);

        Auth::user()->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        return redirect()->route('profile.edit')->with('success', 'Update Successfully');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('login');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}
