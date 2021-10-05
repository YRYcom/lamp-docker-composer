<?php

namespace App\Collections;

use App\Models\RubriqueTreso;
use Illuminate\Database\Eloquent\Collection;

class RubriqueTresos extends Collection
{
    public function getAllMontant($annee, $mois=null, $pointe=null)
    {
        $montant=0;

        /** @var RubriqueTreso $rubriqueTreso */
        foreach ($this->all() as $rubriqueTreso) {
            $montant += $rubriqueTreso->getAllMontant($annee, $mois, $pointe);
        }

        return $montant;
    }

    public function getMontant($annee, $mois=null)
    {
        return $this->getAllMontant($annee, $mois, 1);
    }

    public function getMontantAttente($annee, $mois=null)
    {
        return $this->getAllMontant($annee, $mois, 0);
    }
}
