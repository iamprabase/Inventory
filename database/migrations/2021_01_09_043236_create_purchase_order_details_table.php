<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade'); 
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
            $table->integer('quantity')->unsigned()->default(1); 
            $table->unsignedDecimal('price', 9, 2)->default(0.00);
            $table->unsignedDecimal('tax_percent', 10,2)->unsigned()->nullable();
            $table->unsignedDecimal('tax_amount', 9, 2)->nullable()->default(0.00);
            $table->unsignedDecimal('amount', 10, 2)->default(0.00);
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
        Schema::dropIfExists('purchase_order_details');
    }
}
