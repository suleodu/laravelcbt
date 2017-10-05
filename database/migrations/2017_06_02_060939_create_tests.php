<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('test_types', function (Blueprint $table) {
            $table->increments('ttypid');
            $table->string('ttypname')->unique()->comment("Test type name (it should be unique)");
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });
        
        
        Schema::create('tests', function (Blueprint $table) {
            $table->string('tid');
            $table->string('assid');
            $table->integer('ttypid')->unsigned()->comment('Test type name i.e(Either Exam, CA or whatever)');
            $table->integer('noq')->comment('Number of Question to be attended');
            $table->integer('mark_obtainable')->comment('Number of Question to be attended');
            $table->enum('rand_question',['true','false'])->default('true');
            $table->enum('image_capture',['true','false'])->default('false');
            $table->enum('show_score',['true','false'])->default('false')->comment('show score to student after end of exam');
            $table->enum('show_rank',['true','false'])->default('false')->comment('show rank to student after end of exam');
            $table->text('start_message')->nullable();
            $table->text('end_message')->nullable();
            $table->enum('category',['CA','EXAM'])->default('CA')->index();
            $table->string('time')->comment('Time Alloted for the test');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
            
            $table->foreign('assid')
                    ->references('assid')
                    ->on('assessments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('ttypid')
                    ->references('ttypid')
                    ->on('test_types')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->primary(['tid']);
            $table->unique(['assid', 'ttypid']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tests');
        Schema::drop('test_types');
    }
}

