<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street');
            $table->string('complement');
            $table->string('number');
            $table->string('neighborhood')->nullable();
            $table->integer('cep')->nullable();
            $table->string('city');
            $table->string('UF');
            $table->foreignId('id_person')->constrained('people');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
