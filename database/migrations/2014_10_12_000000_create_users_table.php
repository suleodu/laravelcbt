<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('userid')->unique();
            $table->string('fname');
            $table->string('lname');
            $table->string('mname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->enum('status', ['active','inactive'])->default('active')->index();
            $table->enum('access', ['super','admin1', 'admin2', 'student'])->default('student')->index();
            $table->enum('is_login', ['true', 'false'])->default('false');
            $table->rememberToken();
            $table->timestamps();
            
            $table->primary(['userid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
