<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBilletsTable extends Migration
{
    public function up()
    {
        Schema::create('billets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bank_id');
            $table->string('bank');
            $table->integer('agency');
            $table->string('title_number');
            $table->integer('title_type');
            $table->integer('currency_code');
            $table->integer('product_id');
            $table->string('client_number');
            $table->integer('partial_payment_id');
            $table->integer('amount_partial_payment')->default(0);
            $table->integer('emission_form');
            $table->bigInteger('currency_amount')->default(0);
            $table->integer('register_title')->default(1);
            $table->date('emission_date');
            $table->date('due_date');
            $table->bigInteger('cpfcnpj_number');
            $table->integer('term_limit')->default(0);
            $table->integer('term_type')->default(0);
            $table->integer('protest_limit')->default(0);
            $table->integer('protest_type')->default(0);
            $table->integer('cpfcnpj_branch');
            $table->bigInteger('negotiation_number');
            $table->bigInteger('iof_value')->default(0);
            $table->bigInteger('nominal_value');
            $table->foreignId('payer_id')->constrained('people');
            $table->foreignId('drawer_id')->constrained('people');
            $table->integer('layout_version')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
