<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

	public function register(Request $requests){
		$fields = $requests->validate([
			'name' => 'required|string',
			'email' => 'required|string|unique:users,email',
			'password' => 'required|string|confirmed',
			'user_type' => 'required|integer|between:0,1'
		]);

		$user = User::create([
			'name' => $fields['name'],
			'email' =>$fields['email'],
			'user_type' =>$fields['user_type'],
			'password' => bcrypt($fields['password']),
		]);

		$token = $user->createToken('aspire-token')->plainTextToken;

		return response([
			'message' => 'Registration Completed Successfully!',
			'user' => $user,
			'token' => $token,
			'code' => 200
		], 200);
	}

	public function login(Request $requests){
		$fields = $requests->validate([
			'email' => 'required|string',
			'password' => 'required|string',
			'user_type' => 'required|integer'
		]);

		$user = User::where(['email' => $fields['email'], 'user_type' => $fields['user_type']])->first();
		//dd(User::all()->toArray());
		if(!$user || !Hash::check($fields['password'], $user->password)){
			return response([
				'message' => 'invalid credentials',
				'code' => 400
			]);
		}

		$token = $user->createToken('aspire-token')->plainTextToken;

		return response([
			'message' => 'Login successfully!',
			'user' => $user,
			'token' => $token,
			'code' => 200
		], 200);
	}

	public function logout(Request $requests){
		auth('sanctum')->user()->tokens()->delete();

		return response([
			'message' => 'You are logged out!',
			'code' => 200
		], 200);
	}
}
