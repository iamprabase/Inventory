<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('category_product', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
          $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); 
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
        Schema::dropIfExists('category_product');
    }
}
