<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::connection(config('boleto.boleto_connection'))->create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('cpf_cnpj')->nullable()->default(0);
            $table->string('reference')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
