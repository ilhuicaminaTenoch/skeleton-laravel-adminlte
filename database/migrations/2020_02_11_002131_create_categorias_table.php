<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('id_arbol_menu');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            $table->string('titulo',100);
            $table->text('descripcion');
            $table->integer('ordenamiento');
            $table->boolean('activo');
            $table->string('pagina',70);
            $table->string('componente', 100);
            $table->boolean('alto_impacto_movil');
            $table->boolean('alto_impacto_apple_tv');
            $table->integer('ordenamiento_alto_impacto_movil');
            $table->integer('ordenamiento_alto_impacto_apple_tv');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
