<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDependanceRubriqueCategorie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rubrique_tresos', function (Blueprint $table) {
            $table->integer('compte_bancaire_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('rubrique_tresos', function($table) {
            $table->dropColumn('compte_bancaire_id');
        });
    }
}

