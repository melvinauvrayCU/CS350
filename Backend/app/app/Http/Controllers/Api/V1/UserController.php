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
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
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

    public function change_password(Request $request){
        $validator = Validator::make($request->all(),[
            'new_password' => 'required',
            'new_password_confirmation' => 'required| same:new_password',
            'old_password' => 'required',
        ]);
        if($validator->fails()){
            $response = [
                'message' => 'Validation failed',
            ];
    
            return response($response, 422);
        }

        $user=$request -> user();
        if(Hash::check($request->old_password, $user -> password)){
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            $response = [
                'message' => 'Password updated successfully',
            ];
            return response($response,200);
        }else{
            $response =[
                'message' => 'Old Password does not match'
            ];
            return response($response,400);
        }
    }

}
