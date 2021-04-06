<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // use HasFactory;

     protected $fillable = [
       'jobs_role','qualificaton','experience','skills','job_type','description',
        'job_crated_by','applied_by'
     ];
    
   }
