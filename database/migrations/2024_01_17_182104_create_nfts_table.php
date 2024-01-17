<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nfts', function (Blueprint $table) {
            $table->id();
            $table->int('user-id');
            $table->string('file');
            $table->int('price');
            $table->string('title');
            $table->string('description');
            $table->string('likes');
            $table->int('category-id');
            $table->int('currency-id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfts');
    }
};
