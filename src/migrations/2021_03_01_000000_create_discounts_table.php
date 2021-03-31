<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::connection(config('boleto.connection'))->create('discounts', function (Blueprint $table) {
            $table->id();
            $table->integer('value')->default(0);
            $table->integer('percent')->default(0);
            $table->date('limit_date')->nullable();
            $table->foreignId('billet_id')->constrained('billets');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
