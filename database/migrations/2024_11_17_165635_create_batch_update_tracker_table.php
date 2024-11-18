<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('batch_update_trackers', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_updates_made')->default(0);
            $table->timestamps();
        });

        DB::table('batch_update_trackers')->insert([
            'batch_updates_made' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_update_trackers');
    }
};
