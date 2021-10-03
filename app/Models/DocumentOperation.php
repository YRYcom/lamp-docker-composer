<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class DocumentOperation
 *
 * @property int $id
 * @property string $original_filename
 * @property string $filename
 * @property int $operation_id
 * @property Operation $operation
 */
class DocumentOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_filename',
        'filename',
        'operation_id',
    ];

    /**
     * @return BelongsTo
     */
    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
    }
}
