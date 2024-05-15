<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'type',
        'zip_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'state',
        'city',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
