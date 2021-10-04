<?php

namespace App\Models;

use App\Collections\RubriqueTresos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class RubriqueTreso
 * @property int $id
 * @property int $designation
 * @property string $type
 * @property-read Categorie[] $categories
 */
class RubriqueTreso extends Model
{
    use HasFactory;

    const TYPE_RECETTE = 0;
    const TYPE_DEPENSE = 1;

    public $usesUsers = true;

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function scopeIsRecetteType($query)
    {
        $query->where('type',self::TYPE_RECETTE);
    }

    public function scopeIsDepenseType($query)
    {
        $query->where('type',self::TYPE_DEPENSE);
    }

    public function getMontant($annee, $mois=null)
    {
        return 0;
    }

    public function getMontantAttente($annee, $mois=null)
    {
        return 0;
    }

    public function newCollection(array $models = [])
    {
        return new RubriqueTresos($models);
    }
}
