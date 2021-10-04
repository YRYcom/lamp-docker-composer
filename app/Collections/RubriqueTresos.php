<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class RubriqueTresos extends Collection
{
    public function getMontant($annee, $mois=null)
    {
        return 0;
    }

    public function getMontantAttente($annee, $mois=null)
    {
        return 0;
    }
}
