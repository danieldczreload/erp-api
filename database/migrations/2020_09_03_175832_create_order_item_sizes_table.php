<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_item_sizes', function (Blueprint $table) {
            $table->id();
            $table->string("size_name");
            $table->integer("qty");
            $table->integer("order_by");
            $table->foreignId("order_item_id")->references("id")->on("order_items");
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
        Schema::dropIfExists('order_item_sizes');
    }
}
