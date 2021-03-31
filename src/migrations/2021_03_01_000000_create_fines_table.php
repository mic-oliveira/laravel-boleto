<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinesTable extends Migration
{
    public function up()
    {
        Schema::connection(config('boleto.connection'))->create('fines', function (Blueprint $table) {
            $table->id();
            $table->integer('value')->default(0);
            $table->integer('percent')->default(0);
            $table->integer('limit_date')->nullable();
            $table->string('days')->default(0);
            $table->foreignId('billet_id')->references('billets');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fines');
    }
}
