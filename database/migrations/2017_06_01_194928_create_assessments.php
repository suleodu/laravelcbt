<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->string('assid')->unique();
            $table->string('csid');
            $table->integer('sesid')->unsigned();
            $table->integer('ca_score')->unsigned();
            $table->integer('ex_score')->unsigned();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            
            $table->foreign('csid')
                    ->references('csid')
                    ->on('courses')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('sesid')
                    ->references('sesid')
                    ->on('sessions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->primary(['assid', 'csid','sesid']);
            $table->unique(['csid','sesid']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assessments');
    }
}
