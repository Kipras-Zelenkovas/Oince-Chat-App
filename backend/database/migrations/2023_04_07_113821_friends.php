<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Enums for this table
     */

    private $status = ['request', 'friends', 'blocked'];


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_1');
            $table->foreignUuid('user_2');
            $table->enum('status', $this->status);
            $table->foreignUuid('user_banned')->nullable()->default(null);
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
        Schema::dropIfExists('friends');
    }
};
