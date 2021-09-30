<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Operation
 *
 * @property int $id
 * @property string $designation
 * @property float $credit
 * @property float $debit
 * @property string $date_realisation
 * @property int $realisation
 * @property int $numero_ordre
 * @property int $categorie_id
 * @property-read Categorie $categorie
 */
class Operation extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    protected $casts = [
        'date_realisation' => 'datetime',
        'realisation' => 'boolean',
    ];
}
