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
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('email');
            $table->string('password');
            $table->json('checkbox')->nullable();
            $table->string('radio');
            $table->string('select');
            $table->string('file');
            $table->text('textarea');
            $table->date('date');
            $table->integer('number');
            $table->integer('range');
            $table->string('color');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_inputs');
    }
};
