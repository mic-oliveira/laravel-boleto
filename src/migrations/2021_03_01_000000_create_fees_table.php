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
            $table->integer('limit_date')->default(0);
            $table->string('days')->default(0);
            $table->foreignId('billet_id')->references('billets');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
