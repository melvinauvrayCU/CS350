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
        Schema::create('recipe_step_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_step_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->foreign('recipe_step_id')->references('id')->on('recipe_steps')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
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
        Schema::dropIfExists('recipe_step_ingredient');
    }
};
