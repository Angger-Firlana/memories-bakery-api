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
        //
        Schema::create('production_schedule_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_schedule_id')->constrained('production_schedules')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('menu_id')->constrained('menus')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
