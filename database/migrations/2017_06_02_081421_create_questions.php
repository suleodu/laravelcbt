<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->string('qid');
            $table->string('tid')->index();
            $table->string('instruction');
            $table->longText('question');
            $table->longText('option1');
            $table->longText('option2');
            $table->longText('option3');
            $table->longText('option4');
            $table->integer('choice');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('tid')
                    ->references('tid')
                    ->on('tests')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->primary(['qid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
