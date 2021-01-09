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
            $table->string('name');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');
            $table->unsignedDecimal('price', 9, 2)->default(0.00);
            $table->unsignedDecimal('purchase_price', 9, 2)->default(0.00);
            $table->mediumText('description')->nullable();
            $table->enum('stock', ['In-stock', 'Out of Stock'])->default('In-stock');
            $table->string('sku', 100)->unique();
            $table->integer('available_quantity')->unsigned()->default(0);
            $table->integer('quantity_level_reminder')->unsigned()->default(0);
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
