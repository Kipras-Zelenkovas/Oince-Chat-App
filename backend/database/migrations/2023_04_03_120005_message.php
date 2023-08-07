<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Enums for this table
     */

    private $status = ['sent', 'seen', 'deleted'];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_from');
            $table->foreignUuid('user_to');
            $table->string('text', 250);
            $table->enum('status', $this->status);
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
        Schema::dropIfExists('message');
    }
};
