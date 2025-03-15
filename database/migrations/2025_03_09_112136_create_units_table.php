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
        Schema::create('units', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Unit name
            $table->float('length'); // Length of the unit
            $table->float('width'); // Width of the unit
            $table->float('price'); // Price of the unit
            $table->string('status')->default('available'); // Status: "rented" or "available"
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
