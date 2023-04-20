<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use App\Rules\ValidSecurityQuestionRule;


class AuthController extends Controller
{
    public function register (Request $request) {
        $fields =$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'bio' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'security_answer_1' => 'required|string',
            'security_answer_2' => 'required|string',
            'security_answer_3' => 'required|string',
            'security_question_1' => 'required|string',
            'security_question_2' => 'required|string',
            'security_question_3' => 'required|string',
            'password' => 'required|string|confirmed', 
            'password_confirmation' => 'required|same:password'
        ]);
        

            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'bio' => $fields['bio'],
                'fname' => $fields['fname'],
                'lname' => $fields['lname'],
                'security_answer_1' => $fields['security_answer_1'],
                'security_answer_2' => $fields['security_answer_2'],
                'security_answer_3' => $fields['security_answer_3'],
                'security_question_1' => $fields['security_question_1'],
                'security_question_2' => $fields['security_question_2'],
                'security_question_3' => $fields['security_question_3'],
                'password' => bcrypt($fields['password'])
            ]);
            
        

        $token =$user -> createToken('usertoken')-> plainTextToken;

        $response = [
            'user' => $user,
            'token' =>$token,
        ];

        return response($response, 201);

    }

    public function check(Request $request)
    {
        if ($request->user() && $request->user()->hasToken()) {
            return response($request->user(),200);
        } else {
            return response('User is not logged in',401);
        }
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
