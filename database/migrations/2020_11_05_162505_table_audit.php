<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('fac_maestro_xml_audit');
        Schema::create('fac_maestro_xml_audit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fac_maestro_xml_id');
            $table->string('mensaje',1000);
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
        Schema::dropIfExists('fac_maestro_xml_audit');
    }
}
