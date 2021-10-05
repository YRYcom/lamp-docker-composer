<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Categorie
 *
 * @property int $id
 * @property string $designation
 * @property int $rubrique_treso_id
 * @property-read RubriqueTreso $rubriqueTreso
 */
class Categorie extends Model
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'rubrique_treso' => $this->rubriqueTreso,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function rubriqueTreso(): BelongsTo
    {
        return $this->belongsTo(RubriqueTreso::class);
    }

    public function getAllMontant($annee, $mois=null, $pointe=null)
    {
        $query = Operation::where('categorie_id', $this->id)
            ->whereYear('date_realisation',(int) $annee);

        if(!is_null($pointe)) {
            $query->where('pointe', 1);
        }

        if(!is_null($mois)) {
            $query->whereMonth('date_realisation',(int) $mois);
        }

        return $query->selectRaw("SUM(IFNULL(credit, 0)) - SUM(IFNULL(debit, 0)) as montant")
                ->first()['montant'] ?? 0;
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
