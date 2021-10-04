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
}
