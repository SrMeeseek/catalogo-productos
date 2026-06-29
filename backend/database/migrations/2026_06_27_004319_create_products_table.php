<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('unit', ['Unidad', 'Display', 'Caja']);
            $table->string('observations', 255);
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();

            $table->index('brand_id');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
