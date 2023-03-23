<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTxnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('txns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('payment_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->decimal('price', 12, 2);
            $table->decimal('price_total', 12, 2);
            $table->tinyInteger('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')->references('id')->on('payment');
            $table->foreign('order_id')->references('id')->on('order');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('membership_id')->references('id')->on('membership');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('txns');
    }
}
