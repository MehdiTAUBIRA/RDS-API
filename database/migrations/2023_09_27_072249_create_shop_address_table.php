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
        Schema::create('shop_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id');
            $table->string('label', 50);
            $table->string('address', 100);
            $table->string('city', 100);
            $table->string('postalcode', 6);
            $table->string('country', 50);
            $table->float('gps_x', 10);
            $table->float('gps_y', 10);
            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_address');
    }
};
