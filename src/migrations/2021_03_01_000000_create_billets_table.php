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
            $table->integer('agency');
            $table->string('title_number');
            $table->integer('title_type');
            $table->integer('currency_code');
            $table->integer('product_id');
            $table->string('client_number');
            $table->integer('partial_payment_id');
            $table->integer('emission_form');
            $table->date('emission_date');
            $table->date('due_date');
            $table->bigInteger('cpfcnpj_number');
            $table->integer('cpfcnpj_branch');
            $table->bigInteger('negotiation_number');
            $table->bigInteger('iof_value')->default(0);
            $table->bigInteger('nominal_value');
            $table->foreignId('payer_id')->constrained('people');
            $table->foreignId('drawer_id')->constrained('people');
            $table->integer('layout_version');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
