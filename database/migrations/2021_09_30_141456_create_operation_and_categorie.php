<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationAndCategorie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->float('credit')->nullable()->default(0);
            $table->float('debit')->nullable()->default(0);
            $table->date('date_realisation')->nullable();
            $table->integer('pointe')->default(0);
            $table->integer('categorie_id');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
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
        Schema::dropIfExists('operations');
        Schema::dropIfExists('categories');
    }
}
