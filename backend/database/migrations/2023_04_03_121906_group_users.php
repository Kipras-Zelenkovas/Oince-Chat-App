<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Enums for this table
     */

    private $status = ['request', 'member', 'banned'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('group_id');
            $table->foreignUuid('user_id');
            $table->foreignUuid('role');
            $table->enum('status', $this->status);
            $table->tinyText('ban_reason')->nullable(true);
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
        Schema::dropIfExists('group_users');
    }
};
