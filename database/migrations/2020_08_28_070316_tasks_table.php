<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projects_id')->constrained('projects'); // foreign key with table projects
            $table->string('title', 255);
            $table->text('description');
            $table->string('status', 10);
            $table->bigInteger('duration')->unsigned(); // project duration in seconds
            $table->boolean('deleted')->default(0); // for soft deleting
            $table->timestamps();
            
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
