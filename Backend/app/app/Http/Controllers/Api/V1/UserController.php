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
        $user_id = $request -> input('user_id');
        $user=User::find($user_id);
        if(!$user){
            $response=[
                'error' => 'User not found'
            ];
            return response($response,404);
        }
        return response($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string',
            'bio' => 'required|string',
            'fname' => 'required|string',
            'lname' => 'required|string',
            'profile_photo' => 'required|image|mimes:jpg,png,bmp'
        ]);
        if($validator->fails()){
            $response = [
                'message' => 'Validations failed',
                'errors' => $validator -> errors()
            ];
    
            return response($response, 422);
        }

        $user = $request->user();
        if($request->HasFile('profile_photo')){
            if($user->profile_photo){
                $old_path = public_path().'uploads/profile_images/'.$user->profile_photo;
                if(File::exists($old_path)){
                    File::delete($old_path);
                }
                    
                $image_name='profile_image-'.time().'.'.$request->profile_photo->extention();
                $request->profile_photo->move(public_path('/uploads/profile_images'),$image_name);
                

            }else{
                $image_name=$user->profile_photo;
            }
        }
        
        $profile_photo_url = url($image_name);
            $user->update([
                'name'=> $request->name,
                'email' => $request -> email,
                'bio' => $request -> bio,
                'fname' => $request -> fname,
                'lname' => $request -> lname,
                'profile_photo' => $image_name,

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

    public function change_Password(Request $request)
{
    $user = $request -> user();

    $validatedData = $request->validate([
        'security_question_1_id' => 'required',
        'security_answer_1_id' => 'required',
        'security_question_2_id' => 'required',
        'security_answer_2_id' => 'required',
        'security_question_3_id' => 'required',
        'security_answer_3_id' => 'required',
        'new_password' => 'required|min:8',
    ]);

    if (
        $user->securityQuestion1->id !== $validatedData['security_question_1_id'] ||
        $user->securityQuestion2->id !== $validatedData['security_question_2_id'] ||
        $user->securityQuestion3->id !== $validatedData['security_question_3_id'] ||
        $user->securityAnswer1->id !== $validatedData['security_answer_1_id'] ||
        $user->securityAnswer2->id !== $validatedData['security_answer_2_id'] ||
        $user->securityAnswer3->id !== $validatedData['security_answer_3_id']
    ) {
        $response =[
            'message' => 'Incorrect security questions or answers'
        ];
        return response($response,422);
    }

    $user->password = Hash::make($validatedData['new_password']);
    $user->save();

    $response =[
        'message' => 'Password changed successfully'
    ];
    return response($response,200);
}


}
