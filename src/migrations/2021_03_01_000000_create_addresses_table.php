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
            $table->string('street')->nullable();
            $table->string('complement')->nullable();
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();
            $table->integer('cep')->nullable();
            $table->string('city')->nullable();
            $table->string('UF')->nullable();
            $table->foreignId('person_id')->constrained('people');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
