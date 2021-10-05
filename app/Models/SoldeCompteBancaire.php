<?php

namespace App\Models;

use Datetime;
use Illuminate\Database\Eloquent\Model;

/**
 *  Class SoldeCompteBancaire
 *
 * @property int $i
 * @property Datetime $date_arret
 * @property float $montant
 */
class SoldeCompteBancaire extends Model
{
    public static function getLast(CompteBancaire $compteBancaire, $annee = null, $mois = null)
    {
        $lastSolde = self::where('compte_bancaire_id', $compteBancaire->id);

        if(!is_null($annee)) {
            $lastSolde->whereDate('date_arret', '<' , $annee.'-' . ( $mois ?? '01' ) . '-01');
        }

        return $lastSolde->orderBy('date_arret', 'DESC')
            ->first();

    }

    public static function getLastMontant(CompteBancaire $compteBancaire) {
        return self::getLast($compteBancaire)->montant;
    }
}
