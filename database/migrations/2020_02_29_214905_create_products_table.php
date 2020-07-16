<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger("id_categoria")->nullable();
            $table->string("nome");
            $table->text("descrição");
            $table->float("preço");
            $table->float("classificacao", 2, 1)->default(0.0);
            $table->integer("stock");
            $table->boolean("disponivel")->default(1);
            $table->string("imagem")->default("prod_default.jpg");
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
