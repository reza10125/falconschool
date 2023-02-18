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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->engine = "InnoDB";
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->date('dob')->nullable();
                $table->date('join_date')->nullable();
                $table->boolean('g_auth')->default(0)->comment('Google 2 step 1 for enable, 0 for disable');
                $table->boolean('email_auth')->default(0)->comment('Email auth 1 for enable, 0 for disable');
                $table->string('secret_key', 64)->nullable();
                $table->string('phone');
                $table->tinyInteger('user_type')->nullable()->comment('0=>student, 1=>teacher, 2=>parent');
                $table->string('last_login_date');
                $table->string('last_login_ip');
                $table->timestamp('email_verified_at')->nullable();
                $table->unsignedBigInteger('parent_id')->nullable()->comment('FK:parent_id(id)');
                $table->index('parent_id');
                $table->foreign('parent_id')->references('id')->on('parents')->onDelete('cascade');
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
