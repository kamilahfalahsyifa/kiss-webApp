<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('component_name');
            $table->string('part_number')->unique();
            $table->string('category');
            $table->integer('stock')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('vendor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
