<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('value')->default(0);
            $table->integer('percent')->default(0);
            $table->date('limit_date')->default('');
            $table->string('days')->default(0);
            $table->foreignId('billet_id')->references('billets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
