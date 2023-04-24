<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Filters\V1\UserFilter;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\AuthController;
use App\Rules\ValidSecurityQuestionRule;


/**
 * Class that handles the different requests method for the /users/ endpoint
 */
class UserController extends Controller
{

    public function index(Request $request)
    {
        $filter = new UserFilter();
        $queryItems = $filter->transform($request);

        if (count($queryItems) == 0) {
            return new UserCollection(User::all());
        } else {
            $users = User::where($queryItems)->paginate();
            return new UserCollection($users->appends($request->query()));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        if (!$user) {
            $response = [
                'error' => 'User not found'
            ];
            return response($response, 404);
        }
        return response($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'bio' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
        ]);
        if ($validator->fails()) {
            $response = [
                'message' => 'Validations failed',
                'errors' => $validator->errors()
            ];

            return response($response, 422);
        }


        $user->update([
            'name' => $request->name,
            'bio' => $request->bio,
            'fname' => $request->fname,
            'lname' => $request->lname,
        ]);
        $response = [
            'user' => $user,
            'message' => 'User updated',
        ];

        return response($response, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function change_Password($id, Request $request)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'security_question' => 'required',
            'security_answer' => 'required',
            'new_password' => 'required',
        ]);


        // Check if the provided security question is one of the user's security questions
        $security_questions = [
            $user->security_question_1,
            $user->security_question_2,
            $user->security_question_3,
        ];

        if (!in_array($request->security_question, $security_questions)) {
            $response = [
                'error' => 'Invalid security question'
            ];
            return response($response, 400);
        }

        // Check if the provided security answer matches the user's stored security answer
        $security_question_index = array_search($request->security_question, $security_questions);
        $security_answer_field = 'security_answer_' . ($security_question_index + 1);

        if ($user->$security_answer_field !== $request->security_answer) {
            $response = [
                'error' => 'Security answer does not match'
            ];
            return response($response, 400);
        }

        // Update the user's password and save to the database
        $user->password = bcrypt($request->new_password);
        $user->save();

        $response = [
            'message' => 'Password updated successfully'
        ];
        return response($response, 200);
    }
}
