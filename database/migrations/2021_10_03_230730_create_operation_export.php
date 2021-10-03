<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationExport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operations', function (Blueprint $table) {
            $table->integer('operation_export_id')->nullable();
        });

        Schema::create('operation_exports', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->integer('compte_bancaire_id');
            $table->integer('nombre_operation')->default(0);
            $table->integer('nombre_fichier')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('operation_exports');

        Schema::table('operations', function($table) {
            $table->dropColumn('operation_export_id');
        });
    }
}

