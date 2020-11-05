<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenEmpresaFelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gen_empresa_fels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gen_empresa_id');
            $table->string('pais', 2);
            $table->string('nit');
            $table->string('razon_social', 120);
            $table->string('nombre_comercial', 120);
            $table->string('direccion');
            $table->unsignedBigInteger('depto_id');
            $table->unsignedBigInteger('munic_id');
            $table->string('codigo_postal');
            $table->string('afiliacion_iva',50);
            $table->string('correo_electronico');            
            $table->string('alias',20);
            $table->string('llave_firma',120);
            $table->string('llave_certifica',120);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gen_empresa_fels');
    }
}
