<?php

use App\Enums\CreatureRaceEnum;
use App\Enums\CreatureTypeEnum;
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
        Schema::create('creatures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('pv');
            $table->integer('atk');
            $table->integer('def');
            $table->integer('speed');
            $table->enum('type', CreatureTypeEnum::values());
            $table->enum('race', CreatureRaceEnum::values());
            $table->integer('capture_rate');
            $table->string('avatar')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creatures');
    }
};
