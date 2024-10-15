<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('creature_weapon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('creature_id');
            $table->unsignedBiginteger('weapon_id');
            $table->foreign('creature_id')->references('id')->on('creatures')->onDelete('cascade');
            $table->foreign('weapon_id')->references('id')->on('weapons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creature_weapon');
    }
};