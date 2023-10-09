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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('first_name', 50);
            $table->enum('gender', ["1", "2", "3"], 1)->nullable();
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('phone', 22)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('postalcode', 6)->nullable();
            $table->string('country',20)->nullable();
            $table->rememberToken();
            $table->date('birthdate', 7)->nullable();
            $table->string('telecopy', 22)->nullable();
            $table->string('siren', 25)->nullable();
            $table->enum('statut', ["pro", "part"], 4)->nullable();
            $table->tinyInteger('state')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
