<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends Controller
{
    public function register (Request $request) {
        $fields =$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'bio' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'profile_photo' => 'required|image|mimes:jpg,png,bmp',
            'password' => 'required|string|confirmed', 
            'password_confirmation' => 'required|same:password'
        ]);
        $path = public_path();
        if($request->file('profile_photo')){
            $user = $request->user();
            $old_path = public_path().'uploads/profile_images/'.$user->profile_photo;
            $image_name='profile_image-'.time().'.'.$request->profile_photo->extention();
            $request->profile_photo->move(public_path('/uploads/profile_images'),$image_name);
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'bio' => $fields['bio'],
                'fname' => $fields['fname'],
                'lname' => $fields['lname'],
                'profile_photo' => $fields['profile_photo'],
                'password' => bcrypt($fields['password']),
                
            ]);
            $message = 'You made it to the right if statement';

        }else{

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'bio' => $fields['bio'],
                'fname' => $fields['fname'],
                'lname' => $fields['lname'],
                'profile_photo' => public_path('/uploads/profile_images/default_profile_pic.jpg'),
                'password' => bcrypt($fields['password'])
            ]);
            $message = 'You went to the wrong if statement';
        }

        $token =$user -> createToken('usertoken')-> plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token,
            'message' => $path
        ];

        return response($response, 201);

    }

    public function login (Request $request) {
        $fields =$request->validate([
            'email' => 'required|string',
            'password' => 'required|string' 
        ]);

        $user = User::where('email' , $fields['email'])->first();

        if(!$user || !Hash::check($fields['password'], $user ->password)){
            return response([
                'message' => 'User credentials incorrect'
            ], 401);
        }

        $token =$user -> createToken('usertoken')-> plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token
        ];

        return response($response, 201);

    }

    public function logout(Request $request){
        $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
