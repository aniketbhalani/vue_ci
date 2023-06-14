<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request as FacadesRequest;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',

            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function register(RegisterRequest $request)
    {
        if (User::where('email', $request->email)->count() === 0) {
            $user = User::create([
                'avatar' => 'Images/user-img1.png',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message' => 'New user registered successfully'], 200);
        } else {
            return response()->json(['error' => 'User already exists'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email|unique:password_resets,email',
        ]);

        $token = Str::random(60);
        $user = new PasswordReset;
        $user->email = $request->email;
        $user->token = $token;
        $user->save();

        // Send the password reset email
        // You can use your email provider or any email library here
        // Example using Laravel's built-in Mail facade:
        Mail::to($request->email)->send(new ResetPassword($user->email, $token));

        return response()->json(['message' => 'Success! Password reset link has been sent to your email: ' . $user->email]);
    }

    public function passwordResetting(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'token' => 'required',
        ]);

        $passwordReset = PasswordReset::where('token', $validatedData['token'])->first();

        if (!$passwordReset) {
            return response()->json(['error' => 'Invalid token.'], 400);
        }

        $user = User::where('email', $passwordReset->email)->first();

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
