<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch', function (Blueprint $table) {
            $table->increments('batchid');
            $table->string('batch_name');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->unique(['batch_name']);
        });
        
        Schema::create('attendants', function (Blueprint $table) {
            $table->string('attndid');
            $table->string('userid');
            $table->string('tid');
            $table->ipAddress('ip_in')->comment('IP Address when login')->nullable();
            $table->macAddress('mac_in')->comment('MAC Address when login')->nullable();
            $table->ipAddress('ip_out')->comment('IP Address when logout')->nullable();
            $table->macAddress('mac_out')->comment('MAC Address when logout')->nullable();
            $table->string('used_time')->comment('used alloted time for the test')->nullable();
            $table->string('user_agent')->comment('User Agent')->nullable();
            $table->string('start_time')->comment('Start time')->nullable();
            $table->binary('image_capture')->comment('Image Capture')->nullable();
            $table->string('end_time')->comment('Start time')->nullable();
            $table->enum('response_status', ['logout', 'end_test', 'active','standby'])->default('standby');
            $table->integer('batchid')->unsigned();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('tid')
                    ->references('tid')
                    ->on('tests')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('userid')
                    ->references('userid')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('batchid')
                    ->references('batchid')
                    ->on('batch')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->primary(['attndid']);
            $table->unique(['userid', 'tid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendants');
        Schema::drop('batch');
    }
}
