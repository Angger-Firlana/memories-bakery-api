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
        Schema::create('production_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branchs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamp('schedule_date');
            $table->foreignId('manager_id')->constrained('managers')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
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
