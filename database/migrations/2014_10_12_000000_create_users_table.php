<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id');
            $table->string('username')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('emailVerified')->nullable();
            $table->string('phone')->nullable();
            $table->string('industry')->nullable();
            $table->string('nationality')->nullable();
            $table->string('languages')->nullable();
            $table->string('current_location')->nullable();
            $table->string('interests')->nullable();
            $table->string('home_town')->nullable();
            $table->string('last_experience')->nullable();
            $table->string('last_designation')->nullable();
            $table->string('department')->nullable();
            $table->string('reasion_for_leaving')->nullable();
            $table->string('total_experience')->nullable();
            $table->string('about')->nullable();
            $table->string('user_type')->nullable();
            $table->string('resume')->nullable();
            $table->string('profilePicture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
