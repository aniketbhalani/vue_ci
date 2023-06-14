<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PasswordReset;
use App\Mail\AdminResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function login(Request $request)
    {
        // Perform backend validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4|max:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();


            return response()->json(['message' => 'Login successful']);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email|unique:password_resets,email',
        ]);

        $token = Str::random(60);
        $user = new PasswordReset;
        $user->email = $request->email;
        $user->token = $token;
        $user->save();

        $mail = Mail::to($request->email)->send(new AdminResetPassword($user['email'], $token));

        return response()->json(['message' => 'Success! Password reset link has been sent to your email: ' . $user->email]);
    }

    public function passwordResetting(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'token' => 'required',
        ]);

        $passwordReset = PasswordReset::where('token', $validatedData['token'])->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Invalid token.'], 400);
        }

        $user = Admin::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Delete the password reset entry
        $passwordReset->delete();

        return response()->json(['message' => 'Password reset successfully.'], 200);
    }
}
