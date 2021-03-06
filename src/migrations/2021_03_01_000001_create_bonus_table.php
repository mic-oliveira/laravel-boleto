<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTable extends Migration
{
    public function up()
    {
        Schema::connection(config('boleto.boleto_connection'))->create('bonus', function (Blueprint $table) {
            $table->id();
            $table->integer('value');
            $table->integer('percent');
            $table->date('limit_date')->nullable();
            $table->foreignId('billet_id')->constrained('billets');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bonus');
    }
}
