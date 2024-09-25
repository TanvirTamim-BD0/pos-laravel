<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInvoiceProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_invoice_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shop_logo')->nullable();
            $table->string('billing_seal')->nullable();
            $table->string('billing_signature')->nullable();
            $table->string('trade_license')->nullable();
            $table->string('name');
            $table->string('company_slogan')->nullable();
            $table->string('tax')->nullable();
            $table->string('tin')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symble')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('billing_terms')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('website')->nullable();
            $table->boolean('status')->default(1);
            $table->string('invoice_design')->nullable();
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
        Schema::dropIfExists('company_invoice_profiles');
    }
}
