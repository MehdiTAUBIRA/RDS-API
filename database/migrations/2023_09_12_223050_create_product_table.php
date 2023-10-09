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
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 50);
            $table->longtext('description');
            $table->bigInteger('shop_id');
            $table->bigInteger('asset_id');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('cascade');
            $table->foreign('asset_id')->references('id')->on('asset')->onDelete('no action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
