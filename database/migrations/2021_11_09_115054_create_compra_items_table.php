<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produto_id')->unsigned();
            $table->bigInteger('compra_id')->unsigned();
            $table->integer('quantidade');
            $table->decimal('valor_unitario');
            $table->decimal('valor_total');
            $table->timestamps();

            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->foreign('compra_id')->references('id')->on('compras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra_items');
    }
}
