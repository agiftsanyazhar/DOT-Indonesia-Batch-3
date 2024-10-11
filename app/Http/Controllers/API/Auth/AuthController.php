<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:6',
            ]);

            $user = User::where('email', $data['email'])->first();

            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw ValidationException::withMessages([
                    'message' => ['The Provided Credentials are Incorrect.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Successfully.',
                'token' => $token,
                'data' => $user,
            ], 200);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->messages();

            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $errors,
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = User::findOrFail($request->user()->id);
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout Successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => ['error' => $e->getMessage()],
            ], 500);
        }
    }
}
