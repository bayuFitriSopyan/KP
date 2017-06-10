<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class AuthController extends Controller
{
	public function register(Request $request, user $user)
	{
		$this->validate($request, [
			'name'   		=> 'required',
			'email'  		=> 'required|email|unique:users',
			'password'		=> 'required|min:6'
		]);

		$user =	$user->create(
			[
				'name'		=> $request->name,
				'email'		=> $request->email,
				'password'	=> bcrypt($request->password),
				'api_token' => bcrypt($request->email)

			]);
		$response = fractal()
			->item($user)
			->transformWith(new UserTransformer)
			->addMeta([
					'token' => $user->api_token,
				])
			->toArray();

		return response()->json($response, 201);
	}

	public function login(Request $request, user $user)
	{
		if(!Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
			return response()->json(['email' => 'gagal login'], 401);
		}

		$user = $user->find(Auth::user()->id);

		return fractal()
			->item($user)
			->transformWith(new UserTransformer)
			->addMeta([
					'token' => $user->api_token,
				])
			->toArray();
	}

	public function logout(){
		try{
            Auth::logout();
            return response()->json(["code" => "200", "message" => "Logout Succes"]);	
		}catch (Exception $e){
			return response()->json($e->getMessage(), 505);	
		}
	}
	
}
