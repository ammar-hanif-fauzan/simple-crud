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
        Schema::create('people_hobbies', function (Blueprint $table) {
            $table->bigInteger('people_id')->unsigned();
            $table->bigInteger('hobby_id')->unsigned();
            $table->timestamps();

            $table->primary(['people_id', 'hobby_id']);

            $table->foreign('people_id')
                ->references('id')
                ->on('people')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('hobby_id')
                ->references('id')
                ->on('hobbies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_hobbies');
    }
};
