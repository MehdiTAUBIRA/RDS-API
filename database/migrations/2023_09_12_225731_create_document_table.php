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
        Schema::create('document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cart_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('shop_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->float('quantity', 5)->nullable();
            $table->datetime('date_com');
            $table->string('product_name', 50);
            $table->bigInteger('id_price')->nullable();
            $table->float('price', 24);
            $table->bigInteger('vat_id')->nullable();
            $table->float('vat', 4);
            $table->float('discount', 10);
            $table->float('price_ttc');
            $table->string('name', 50);
            $table->float('status', 1)->nullable();
            $table->datetime('validation_date');
            $table->timestamps();
            $table->foreign('cart_id')->references('id')->on('cart')->onDelete('no action');
            $table->foreign('user_id')->references('id')->on('shop')->onDelete('no action');
            $table->foreign('shop_id')->references('id')->on('shop')->onDelete('no action');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('no action');
            $table->foreign('id_price')->references('id')->on('price')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
