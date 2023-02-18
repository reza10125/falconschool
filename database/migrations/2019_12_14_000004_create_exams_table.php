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
        if (!Schema::hasTable('exams')) {
            Schema::create('exams', function (Blueprint $table) {
                $table->engine = "InnoDB";
                $table->id();
                $table->unsignedBigInteger('exam_type_id')->nullable()->comment('FK:exam_type_id(id)');
                $table->index('exam_type_id');
                $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('cascade');

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
        Schema::dropIfExists('exams');
    }
};
