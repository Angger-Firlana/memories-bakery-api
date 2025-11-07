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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained('branchs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            
            $table->timestamp('date_production');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_production');
    }
};
