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
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('cook_time')->nullable();
            $table->string('prep_time')->nullable();
            $table->integer("recipe_id");
            // $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            //ingredients
            //utensils

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
        Schema::dropIfExists('recipe_steps');
    }
};
