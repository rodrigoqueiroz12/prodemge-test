<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Person extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'alternate_name',
        'document',
        'father_name',
        'mother_name',
        'phone',
        'email',
    ];


    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds(): array
    {
        return ['public_id'];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(PersonAddress::class);
    }
}
