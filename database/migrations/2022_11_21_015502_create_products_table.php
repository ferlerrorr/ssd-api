<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('generic_name', 100 )->nullable();
            $table->string('grams', 100 )->nullable();
            $table->string('product_name', 100 );
            $table->string('category', 100 )->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('variant_id')->nullable();
            $table->integer('level')->length(1)->default(0);
            $table->string('price', 255);
            $table->string('compare_at_price', 255)->nullable();
            $table->string('keywords', 255 )->nullable();
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
