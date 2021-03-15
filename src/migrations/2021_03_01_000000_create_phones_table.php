<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('ddd');
            $table->foreignId('person_id')->constrained('people');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billets');
    }
}
