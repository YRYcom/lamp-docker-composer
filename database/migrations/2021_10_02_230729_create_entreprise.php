<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operations', function (Blueprint $table) {
            $table->integer('compte_bancaire_id');
        });

        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('entreprise_user', function (Blueprint $table) {
            $table->id();
            $table->integer('entreprise_id');
            $table->integer('user_id');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->integer('entreprise_id');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('compte_bancaire_user', function (Blueprint $table) {
            $table->id();
            $table->integer('compte_bancaire_id');
            $table->integer('user_id');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('solde_compte_bancaires', function (Blueprint $table) {
            $table->id();
            $table->dateTime('$ate_arret');
            $table->integer('montant');
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
        Schema::dropIfExists('entreprises');
        Schema::dropIfExists('compte_bancaires');
        Schema::dropIfExists('entreprise_user');
        Schema::dropIfExists('compte_bancaire_user');
        Schema::dropIfExists('solde_compte_bancaires');
    }
}

