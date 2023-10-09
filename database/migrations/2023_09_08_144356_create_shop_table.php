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
        Schema::create('shop', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('siret', 14);
            $table->string('shop_name', 100);
            $table->string('contactname', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('telecopy', 20)->nullable();
            $table->string('email', 22);
            $table->biginteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('logo')->nullable();
            $table->int('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop');
    }
};
