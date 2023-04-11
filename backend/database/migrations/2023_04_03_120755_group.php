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
        Schema::create('group', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner');
            $table->string('name');
            $table->string('image');
            $table->enum('status', ['open', 'private']);
            $table->enum('tags', ['sports', 'gaming', ' programming', 'design', ' art', 'studies']);
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
        Schema::dropIfExists('group');
    }
};
