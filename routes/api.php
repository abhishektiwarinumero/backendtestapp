<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\UserController;

Route::post('signin', [ApiController::class, 'authenticate']);
Route::post('login', [ApiController::class, 'companylogin']);
Route::post('signup', [ApiController::class, 'register']);
Route::post('resetpassword', [VerificationController::class, 'resetpassword']);
Route::post('forgotpassword', [VerificationController::class, 'forgotpassword']);
Route::post('createJob', [JobsController::class, 'addjobs']);
Route::get('allJob', [JobsController::class, 'alljobs']);
Route::get('job/{id}', [JobsController::class, 'getsiglejob']);
Route::get('createdBy/{id}', [JobsController::class, 'jobcreatedby']);
Route::get('appliedBy/{id}', [JobsController::class, 'appliedjobs']);
Route::post('updateProfile',  [UserController::class, 'updateuserdetails']);
Route::post('uplods',  [UserController::class, 'postUploadForm']);
Route::get('user/{id}', [UserController::class, 'getuser']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::post('create', [ProductController::class, 'store']);
    Route::put('update/{product}',  [ProductController::class, 'update']);
    Route::delete('delete/{product}',  [ProductController::class, 'destroy']);
});