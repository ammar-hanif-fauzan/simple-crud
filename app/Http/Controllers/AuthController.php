<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user
     * 
     * Mendaftarkan user baru
     * 
     * @param string name Nama user
     * @param string email Email user
     * @param string password Password user
     * @param string password_confirmation Konfirmasi password
     * @tags Authentication
     */
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    /**
     * Login user
     * 
     * Login user dengan email dan password
     * 
     * @param string email Email user
     * @param string password Password user
     * @tags Authentication
     * @OA\Post(
     *   path="/api/v1/login",
     *   summary="Login user",
     *   description="Login user dengan email dan password",
     *   tags={"Authentication"},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="email", type="string", example="user@example.com"),
     *       @OA\Property(property="password", type="string", example="password123")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Login successful",
     *     @OA\JsonContent(
     *       @OA\Property(property="user", type="object"),
     *       @OA\Property(property="token", type="string")
     *     )
     *   )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password,
        $user->password)){
            return [
                'message' => 'The Provided Credentials are Incorrect.'
            ];
        }

        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    /**
     * Logout user
     * 
     * Logout user dan hapus token
     * @tags Authentication
     * @OA\Post(
     *   path="/api/v1/logout",
     *   summary="Logout user",
     *   description="Logout user dan hapus token",
     *   tags={"Authentication"},
     *   @OA\Response(
     *     response=200,
     *     description="Logout successful",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Logged out successfully")
     *     )
     *   )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You Are Logged Out.'
        ];
    }
}