<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Categorie
 *
 * @property int $id
 * @property string $designation
 */
class Categorie extends Model
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'designation' => $this->designation,
        ];
    }
}