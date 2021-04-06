<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class JobsController extends Controller
{


   public function alljobs()
  {
    $jobs = Job::all();
    return response()->json([
    "success" => true,
    "message" => " All jobs list",
    "data" => $jobs
    ]);
  }

  public function getsiglejob($id)
  {
    $jobs = Job::find($id);
    if (is_null($jobs)) {
       return response()->json(['error' => 'job not found'], 400);
    // return $this->sendError('.');
    }
    return response()->json([
    "success" => true,
    "message" => "job retrieved successfully.",
    "data" => $jobs
    ]);
  }

  public function appliedjobs($id)
  {
    $jobs = Job::select("*") ->where([["applied_by", "=", $id]])->get();
    if (is_null($jobs)) {
       return response()->json(['error' => 'job not found'], 400);
    // return $this->sendError('.');
    }
    return response()->json([
    "success" => true,
    "message" => "job retrieved successfully.",
    "data" => $jobs
    ]);

  }

   public function jobcreatedby($id)
  {

    $jobs = Job::select("*") ->where([["job_crated_by", "=", $id]])->get();
    if (is_null($jobs)) {
       return response()->json(['error' => 'job not found'], 400);
    // return $this->sendError('.');
    }
    return response()->json([
    "success" => true,
    "message" => "job retrieved successfully.",
    "data" => $jobs
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



public function updateJob(Request $request, Job $job)
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
          $job =  Job::update(array_merge( $request->all() ));
    // $job->name = $input['name'];
    // $job->detail = $input['detail'];
    // $job->save();
    return response()->json([
    "success" => true,
    "message" => "Job updated successfully.",
    "data" => $job
    ]);
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
