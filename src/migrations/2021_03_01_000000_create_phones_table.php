<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    public function up()
    {
        Schema::connection(config('boleto.boleto_connection'))->create('phones', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('ddd');
            $table->foreignId('person_id')->constrained('people');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phones');
    }
}
