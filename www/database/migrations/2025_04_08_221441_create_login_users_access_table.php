<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {

        Schema::create('login_users_access', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('service');
            $table->json('request_body')->nullable();
            $table->unsignedSmallInteger('http_response_code');
            $table->json('response_body')->nullable();
            $table->ipAddress('ip_request')->nullable();
            $table->timestamps();

            // aunque la api no posee metodo d borrado
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('login_users_access');
    }
};
