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
            $table->string('code_number')->nullable()->after('id');
            $table->string('category')->nullable()->after('component_id');
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
