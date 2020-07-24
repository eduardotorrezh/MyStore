<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaypalIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_ids', function (Blueprint $table) {
            $table->id();
            $table->string('pay_id');
            $table->unsignedBigInteger('sc_id');
            $table->unsignedBigInteger('bas_id');
            $table->timestamps();
            $table->foreign('sc_id')->references('id')->on('shopping_carts')->onDelete('cascade');
            $table->foreign('bas_id')->references('id')->on('buy_and_sells')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_ids');
    }
}
