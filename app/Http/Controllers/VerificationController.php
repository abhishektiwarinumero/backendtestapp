<?php

namespace App\Http\Controllers;
use App\Models\VerifyUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{

public function verifyUser(Request $request)
{
   $token = $request->token;
   $data  = DB::table('verify_users')->where('token', $token)->first();
  if($data){
     $result = DB::table('users')->where('email',$data->email)
    ->update([
        'emailVerified' => "your email is verified"
   ]);
   if($result){
    return response()->json([
        'status'=>200,
        'massage' => 'Your e-mail is verified. You can now login',
    ], 200);
    }
   else{
    return response()->json([
        'status'=>400,
        'massage' => 'Sorry your email cannot be identified',

    ], 400);
   }

}
}


public function resendsendMail(Request $request){
    $email = $request->email;
    $data  = DB::table('users')->where('email', $email)->first();
    if($data){
       if($data->emailVerified === 'your email is verified'){
            return response()->json([
                'status'=>200,
                'massage' => 'Email already verified',
            ], 200);
         }
         else{
            $token = rand(1000,9999);
            DB::table('verify_users')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
             ]);
            
            $emaildata = Mail::to($email)->send(new SendMail($token,$email));
                return response()->json([
                    'status'=>200,
                    'massage' => 'please check your mail',
                  ], 200);
          }
    }
       else{
        return response()->json([
            'status'=>400,
            'massage' => 'Sorry your email cannot be found',
    
        ], 400);
       }

   }





public function forgotpassword(Request $request){
  //Validate data
        $data = $request->only( 'email');
        $validator = Validator::make($data, [
            'email' => 'required|email',
           
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


    $email = $request->email;
    $data  = DB::table('users')->where('email', $email)->first();
    if($data){
      $token = rand(1000,9999);
             DB::table('verify_users')->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now()
             ]);
            
            $emaildata = Mail::to($email)->send(new SendMail($token,$email));
                return response()->json([
                    'status'=>200,
                    'massage' => 'please check your mail',
                  ], 200);
        
    }
       else{
        return response()->json([
            'status'=>400,
            'massage' => 'Sorry your email cannot be found in our database',
    
        ], 400);
       }

   }



public function resetpassword(Request $request)
{
       $data = $request->only( 'otp','password');
        $validator = Validator::make($data, [
            'otp' => 'required',
            'password'=>'required'
           
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

   $token = $request->otp;
   $newpassword =$request->password;
   $data  = DB::table('verify_users')->where('token', $token)->first();
  if($data){
     $result = DB::table('users')->where('email',$data->email)
    ->update([
        'password' =>  bcrypt($newpassword),
   ]);
   if($result){
    return response()->json([
        'status'=>200,
        'massage' => 'Your Password Reset Successfully',
    ], 200);
    }
   else{
    return response()->json([
        'status'=>400,
        'massage' => 'Sorry your email cannot be identified',

    ], 400);
   }

}

else{
    return response()->json([
        'status'=>400,
        'massage' => 'Sorry Please check your OTP',

    ], 400);
   }
}

public function notfound(){
    return response()->json([
        'status'=>400,
        'massage' => 'Unauthenticated User',
      ],400);

}
  


}
