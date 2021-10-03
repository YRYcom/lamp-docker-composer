<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class CompteBancaire
 *
 * @property int $id
 * @property string $designation
 * @property integer $entreprise_id
 */
class CompteBancaire  extends Model
{
    public function toArray()
    {
      return [
          'id' => $this->id,
          'designation' => $this->designation,
      ];
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function solde()
    {
        return SoldeCompteBancaire::getLastMontant($this)
            +Operation::where('pointe',1)->sum('credit')
            -Operation::where('pointe',1)->sum('debit');
    }
}
