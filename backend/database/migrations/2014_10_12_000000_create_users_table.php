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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique()->nullable(true)->default(null);
            $table->text('bio')->nullable(true)->default(null);
            $table->string('image')->nullable(true)->default(null);
            $table->string('provider');
            $table->string('role_id');
            $table->boolean('banned');
            $table->string('age')->nullable(true)->default(null);
            $table->string('gender')->nullable(true)->default(null);
            $table->string('country')->nullable(true)->default(null);
            $table->timestamp('last_seen')->nullable(true)->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
        });
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
