<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apl_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apl_sheet_id')->constrained('apl_sheets')->onDelete('cascade');
            $table->string('part_number');
            $table->string('stock_code');
            $table->text('description')->nullable();
            $table->integer('qty')->default(0);
            $table->string('stock');
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('wr')->nullable();
            $table->enum('remarks_install', ['YES', 'NO'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apl_items');
    }
};