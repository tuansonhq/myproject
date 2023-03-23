<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('bill_code')->unique();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('membership_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('params')->nullable();
            $table->decimal('price_of_prepayment', 12, 2)->nullable();
            $table->decimal('price_total', 12, 2)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('author_id')->references('id')->on('users');
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
        Schema::dropIfExists('order');
    }
}
