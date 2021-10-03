<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OperationExport
 * @property int $id
 * @property string $designation
 * @property integer $nombre_operation
 * @property integer $nombre_fichier
 */
class OperationExport extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'created_by'
    ];
}
