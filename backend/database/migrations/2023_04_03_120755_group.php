<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Enums for this table
     */

    private $tags = ['sports', 'gaming', ' programming', 'design', ' art', 'studies', 'life', 'basics', 'disscussions'];
    private $status = ['open', 'private', 'deleted'];

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
            $table->string('image')->nullable()->default(null);
            $table->enum('status', $this->status);
            $table->enum('tags', $this->tags);
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
