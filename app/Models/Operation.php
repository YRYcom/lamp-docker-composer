<?php

namespace App\Models;

use DateTime;
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
 * @property DateTime $date_realisation
 * @property int $pointe
 * @property int $numero_ordre
 * @property int $categorie_id
 * @property-read Categorie $categorie
 */
class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'categorie_id',
        'date_realisation',
        'designation',
        'credit',
        'debit',
        'user_id',
    ];

    public function toArray() {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'credit' => $this->credit,
            'debit' => $this->debit,
            'pointe' => $this->pointe,
            'numero_ordre' => $this->numero_ordre,
            'date_realisation' => $this->date_realisation?->format('d/m/Y'),
            'categorie' => $this->categorie,
            'categorie_id' => $this->categorie->id,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    protected $casts = [
        'date_realisation' => 'datetime',
        'pointe' => 'boolean',
    ];
}
