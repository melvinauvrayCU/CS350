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
        Schema::create('utensil_utensil_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utensil_id');
            $table->unsignedBigInteger('utensil_category_id');

            $table->foreign('utensil_category_id')->references('id')->on('utensil_categories')->onDelete('cascade');
            $table->foreign('utensil_id')->references('id')->on('utensils')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utensil_utensil_category');
    }
};
