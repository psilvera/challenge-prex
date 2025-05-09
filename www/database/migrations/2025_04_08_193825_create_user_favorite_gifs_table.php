<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::create('user_favorite_gifs', function (Blueprint $table) {
            $table->id();
            $table->string('gif_id');
            $table->string('alias');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // aunque la api no posee metodo d borrado
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // el user no puede guardar el mismo gif
            $table->unique(['user_id', 'gif_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('user_favorite_gifs');
    }
};
