<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // create_menus_table.php
public function up()
{
    Schema::create('menus', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->string('name');
        $table->string('description');
        $table->float('normal_price');
        $table->float('discount_price')->nullable();
        $table->uuid('users_id');
        $table->string('status');
        $table->string('category');
        $table->string('image');
        $table->timestamps();
        
        $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
