<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('classroom_students')) {
            Schema::create('classroom_students', function (Blueprint $table) {
                $table->engine = "InnoDB";
                $table->id();
                $table->unsignedBigInteger('student_id')->nullable()->comment('FK:student_id(id)');
                $table->unsignedBigInteger('classroom_id')->nullable()->comment('FK:classroom_id(id)');
                $table->index('student_id');
                $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
                $table->index('classroom_id');
                $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classroom_students');
    }
};
