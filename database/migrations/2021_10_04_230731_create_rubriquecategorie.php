<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubriqueCategorie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('rubrique_treso_id')->nullable();
        });

        Schema::create('rubrique_tresos', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->string('designation');
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
        Schema::dropIfExists('rubrique_tresos');

        Schema::table('categories', function($table) {
            $table->dropColumn('rubrique_treso_id');
        });
    }
}

