<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{




public function updateuser(Request $request)
  { 
    // return $user;

     $user =  User::update(array_merge( $request->all() ));
   
    return response()->json([
    "success" => true,
    "message" => "user updated successfully.",
    "data" => $user
    ]);
  }


 public function updateuserdetails(Request $request)
    {
          $data = User::find($request->id);
          $data->phone = $request->phone;
          $data->dob = $request->dob;
          $data->save();

        //Product updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $data
        ], Response::HTTP_OK);
    }


public function postUploadForm(Request $request)
{

 if($request->hasfile('file'))
         {

            foreach($request->file('file') as $file)
            {
                $filename=$file->getClientOriginalName();
                $file->move(public_path().'/files/', $name);  
                $insert[]['file'] = "$filename";
            }
         }
            return response()->json([
            'success' => true,
            'message' => 'User uploaded successfully',
             // 'data' => $data
        ], Response::HTTP_OK);
        }


   

       

   public function alljobs()
  {
    $users = User::all();
    return response()->json([
    "success" => true,
    "message" => " All users list",
    "data" => $users
    ]);
  }

  public function getuser($id)
  {
    $users = User::find($id);
    if (is_null($users)) {
    return response()->json(['error' => 'user not found'], 400);
    }
    return response()->json([
    "success" => true,
    "message" => "users retrieved successfully.",
    "data" => $users
    ]);
  }
      
   public function addjobs(Request $request)
    {
        //Validate data
          $data = $request->only('jobs_role', 'qualificaton', 'experience', 
        	'skills','job_type','description');
             $validator = Validator::make($data, [
            'jobs_role' => 'required',
            'qualificaton' => 'required',
            'experience' => 'required',
            'skills' => 'required',
            'job_type' => 'required',
            'description' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


          $newjob =  Job::create(array_merge( $request->all() ));

        //User created, return success response
         return response()->json([
             'status'=>200,
             'success' => true,
             'message' => 'New Job created successfully',
             'data' => $newjob
        ], Response::HTTP_OK);
    }




/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, Job $job)
  {
    $data = $request->only('jobs_role', 'qualificaton', 'experience', 
          'skills','job_type','description');
             $validator = Validator::make($data, [
            'jobs_role' => 'required',
            'qualificaton' => 'required',
            'experience' => 'required',
            'skills' => 'required',
            'job_type' => 'required',
            'description' => 'required'
        ]);
      // if($validator->fails()){
      // return $this->sendError('Validation Error.', $validator->errors());       
      // }
     if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
    $job->name = $input['name'];
    $job->detail = $input['detail'];
    $job->save();
    return response()->json([
    "success" => true,
    "message" => "Job updated successfully.",
    "data" => $Job
    ]);
  }
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy(Job $job)
  {
    $job->delete();
    return response()->json([
    "success" => true,
    "message" => "job deleted successfully.",
    "data" => $job
    ]);
  }

   
}

