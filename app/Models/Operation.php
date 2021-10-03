<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Operation
 *
 * @property int $id
 * @property string $designation
 * @property float $credit
 * @property float $debit
 * @property DateTime $date_realisation
 * @property int $pointe
 * @property int $categorie_id
 * @property  int $compte_bancaire_id
 * @property-read Categorie $categorie
 * @property-read CompteBancaire $compteBancaire
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
        'compte_bancaire_id',
    ];

    public function toArray() {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
            'compte_bancaire' => $this->compteBancaire,
            'credit' => $this->credit,
            'debit' => $this->debit,
            'pointe' => $this->pointe,
            'credit_tostring' => $this->credit == 0 ? '': number_format($this->credit ,2, '.', ' '),
            'debit_tostring' => $this->debit == 0 ? '' : number_format($this->debit ,2, '.', ' '),
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

    /**
     * @return BelongsTo
     */
    public function compteBancaire(): BelongsTo
    {
        return $this->belongsTo(CompteBancaire::class);
    }


    public function documents()
    {
        return $this->hasMany(DocumentOperation::class);
    }

    protected $casts = [
        'date_realisation' => 'datetime',
        'pointe' => 'boolean',
    ];
}
