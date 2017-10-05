<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->string('qid');
            $table->string('attndid');
            $table->integer('choice')->nullable();
            $table->enum('status', ['true','false'])->nullable();
            $table->timestamps();

            $table->foreign('qid')
                    ->references('qid')
                    ->on('questions')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('attndid')
                    ->references('attndid')
                    ->on('attendants')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->primary(['qid', 'attndid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('choices');
    }
}
