<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableXml extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fac_maestro_xml');
        Schema::create('fac_maestro_xml', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gen_empresa_fel_id');
            $table->unsignedBigInteger('periodo',4);
            $table->string('tipodoc', 2);
            $table->string('serie', 3);
            $table->unsignedBigInteger('numdoc',10);
            $table->date('fecha_emision');
            $table->string('nombre_factura');
            $table->string('correo_electronico');
            $table->decimal('total_documento', 12,2);
            $table->MEDIUMTEXT('xml');
            $table->string('flag',1)->nullable();
            $table->string('sat_autorizacion',120)->nullable();
            $table->string('sat_seriefel',120)->nullable();
            $table->string('sat_correlativofel',120)->nullable();
            $table->date('fecha_fel')->nullable();
            $table->MEDIUMTEXT('sat_xml')->nullable();
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
        Schema::dropIfExists('fac_maestro_xml');
    }
}
