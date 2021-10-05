<?php

namespace App\Models;

use App\Collections\RubriqueTresos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class RubriqueTreso
 * @property int $id
 * @property int $designation
 * @property int $compte_bancaire_id
 * @property string $type
 * @property-read Categorie[] $categories
 */
class RubriqueTreso extends Model
{
    use HasFactory;

    const TYPE_RECETTE = 0;
    const TYPE_DEPENSE = 1;

    public $usesUsers = true;

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    public function scopeIsRecetteType($query)
    {
        $query->where('type',self::TYPE_RECETTE);
    }

    public function scopeIsDepenseType($query)
    {
        $query->where('type',self::TYPE_DEPENSE);
    }

    public function getAllMontant($annee, $mois=null, $pointe=null)
    {
        $query = Operation::whereIn('categorie_id', ($this->categories?->pluck('id') ?? []))
            ->whereYear('date_realisation',(int) $annee);

        if(!is_null($pointe)) {
            $query->where('pointe', 1);
        }

        if(!is_null($mois)) {
            $query->whereMonth('date_realisation',(int) $mois);
        }

        $montant = $query->selectRaw("SUM(IFNULL(credit, 0)) - SUM(IFNULL(debit, 0)) as montant")
                ->first()['montant'] ?? 0;

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

    public function newCollection(array $models = [])
    {
        return new RubriqueTresos($models);
    }
}
