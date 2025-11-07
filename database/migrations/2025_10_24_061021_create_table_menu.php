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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('types')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('branch_id')->constrained('branchs')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->string('name');
            $table->decimal('price');
            $table->integer('validDuration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_menu');
    }
};
