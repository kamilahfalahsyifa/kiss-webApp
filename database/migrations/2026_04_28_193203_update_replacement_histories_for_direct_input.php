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
        Schema::table('replacement_histories', function (Blueprint $table) {
            $table->string('component_name')->nullable()->after('category');
            $table->string('pic')->nullable()->after('component_name');
            $table->unsignedBigInteger('unit_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('replacement_histories', function (Blueprint $table) {
            //
        });
    }
};
