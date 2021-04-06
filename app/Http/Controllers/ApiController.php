<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
      
        $data = $request->only('email', 'password');
        $validator = Validator::make($data, [
            // 'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

          $user = new User();
          $id = sha1(time());

        if ($request->hasFile('profilePicture'))
        {
            $file      = $request->file('profilePicture');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('/uploads/profile/'), $picture);
            $profileImg = "/uploads/profile/".$picture;


            $user->profilePicture =$profileImg;
       } 
       
        if ($request->hasFile('resume'))
        {
            $file      = $request->file('resume');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $file->move(public_path('/uploads/resumes/'), $picture);
            $resuneFile= "/uploads/resumes/".$picture;
            $user->resume =$resuneFile;

           } 
        

          $newuser = User::create(array_merge(
          $request->all(),
          ['id' => $id],
          ['password' => bcrypt($request->password)],
          
         ));
            $token = JWTAuth::fromUser($newuser);

        //User created, return success response
         return response()->json([
             'status'=>200,
             'success' => true,
             'message' => 'User created successfully',
             'token'=>$token,
             'data' => $newuser
        ], Response::HTTP_OK);
    }



    public function companylogin(Request $request)
    {
        $credentials = $request->only('company_name', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'company_name' => 'required',
            'password' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                  'success' => false,
                  'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
           return $credentials;
           return response()->json([
               'success' => false,
               'message' => 'Could not create token.',
           ], 500);
       }

    //Token created, return with success response and jwt token
       return response()->json([
            'status'=>200,
            'success' => true,
            'message' => 'User Login successfully',
            'token'=>$token,
            'data' => auth()->user()
    ]);
   }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
           return $credentials;
           return response()->json([
               'success' => false,
               'message' => 'Could not create token.',
           ], 500);
       }

 		//Token created, return with success response and jwt token
       return response()->json([
            'status'=>200,
            'success' => true,
            'message' => 'User Login successfully',
            'token'=>$token,
            'data' => auth()->user()
    ]);
   }

   public function logout(Request $request)
   {
        //valid credential
    $validator = Validator::make($request->only('token'), [
        'token' => 'required'
    ]);

        //Send failed response if request is not valid
    if ($validator->fails()) {
        return response()->json(['error' => $validator->messages()], 200);
    }

		//Request is validated, do logout        
    try {
        JWTAuth::invalidate($request->token);

        return response()->json([
            'success' => true,
            'message' => 'User has been logged out'
        ]);
    } catch (JWTException $exception) {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, user cannot be logged out'
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}

public function get_user(Request $request)
{
    $this->validate($request, [
        'token' => 'required'
    ]);

    $user = JWTAuth::authenticate($request->token);

    return response()->json(['user' => $user]);
}
}
