<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Auth;

class UserController extends Controller
{
    public function users(User $user)
    {
    	$users = $user->all();
    	return fractal()
    			->collection($users)
    			->transformWith(new UserTransformer)
    			->toArray();
    }

    public function profile(user $user)
    {
    	$user = Auth::user(); 
    	$data = $user->find(Auth::user()->id);

    	return response()->json([$data]);		
    }


    public function edit(UpdateAccount $req)
    {
    	$user = Auth::user(); 

    	return response()->json([$user]);		
    }
}

