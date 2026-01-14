<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // add column with default 0 so it can be non-nullable
            $table->integer('remaining_seats')->default(0);
        });

        // populate existing rows with capacity values
        DB::table('courses')->whereNotNull('capacity')->update(['remaining_seats' => DB::raw('capacity')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('remaining_seats');
        });
    }
};
