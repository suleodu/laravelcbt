<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamCenters extends Migration
{
    /*
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_centers', function (Blueprint $table) {
            $table->string('centerid');
            $table->string('center_name')->unique();
            $table->ipAddress('visitor');
            $table->enum('status',['active', 'inactive'])->default('inactive')->index();
            $table->timestamps();
            
            $table->primary(['centerid']);
        });
    }

    
    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exam_centers');
    }
}
