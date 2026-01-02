<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class UserController extends Controller
{
    use AuthorizesRequests;
    public function register(CreateUserRequest $createUserRequest){
        $validated_data = $createUserRequest->validated();
        if(Carbon::parse($validated_data['date_of_birth'])->age < 18){
            return response('You are under age!' , 422);
        }else{
            $validated_data['password'] = Hash::make($validated_data['password']);
            $validated_data['age'] = Carbon::parse($validated_data['date_of_birth'])->age;
            $user = User::create($validated_data);
            return new UserResource($user);
        }
    }

    public function login(LoginUserRequest $loginUserRequest){
        $validated_data = $loginUserRequest->validated();
        if(Auth::attempt($validated_data)){
            $user = Auth::user();
            try{
                $this->authorize('not_banned' , $user);
                return response()->json([
                    'access_token' => $user->createToken('token-name', ['server:update'])->plainTextToken,
                    'user' => new UserResource($user)
                ]);
            }catch (\Illuminate\Auth\Access\AuthorizationException $e){
                return response()->json([
                    'error' => 'Your account has been banned!'
                ], 403);
            }

        }else{
            return response()->json([
                'error' => 'Invalid Data!'
            ] , 403);
        }
        
    }

    public function update(UpdateUserRequest $updateUserRequest , User $user){
        try{
            $this->authorize('not_banned' , $user);
            $validated_data = $updateUserRequest->validated();
            $user->update($validated_data);
            return new UserResource($user);
        }catch(\Illuminate\Auth\Access\AuthorizationException $e){
            return response()->json([
                'error' => 'Your account has been banned!'
            ], 403);
        }


    }

    public function get_user(User $user){
        return new UserResource($user);
    }
}
