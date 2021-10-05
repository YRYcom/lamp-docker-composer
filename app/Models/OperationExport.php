<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OperationExport
 * @property int $id
 * @property int $compte_bancaire_id
 * @property string $designation
 * @property integer $nombre_operation
 * @property integer $nombre_fichier
 */
class OperationExport extends Model
{
    use HasFactory;

    public function setDefaultDesignation() {
        $this->designation = 'Export éxécuté le ' . date('d/m/Y à H:i:s ');
        return $this;
    }

    protected $fillable = [
        'designation',
        'created_by',
        'compte_bancaire_id',
    ];
}
