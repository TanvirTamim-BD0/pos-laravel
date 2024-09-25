<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('selling_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('total_product')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('selling_amount')->nullable();
            $table->string('tax')->nullable();
            $table->string('discount')->nullable();
            $table->string('special_discount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('due_amount')->nullable();
            $table->string('change_amount')->nullable();
            $table->string('selling_month')->nullable();
            $table->string('selling_date')->nullable();
            $table->string('payment_type')->nullable();
            $table->text('payment_note')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('selling_id')->references('id')->on('sells')->onDelete('cascade');
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
        Schema::dropIfExists('sell_payments');
    }
}
