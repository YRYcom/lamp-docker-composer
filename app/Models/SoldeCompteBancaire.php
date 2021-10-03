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
    public static function getLastMontant(CompteBancaire $compteBancaire)
    {
        $lastSolde = self::where('compte_bancaire_id', $compteBancaire->id)->orderBy('date_arret', 'DESC')->latest()->first();

        return $lastSolde?->montant ?? 0;
    }
}
