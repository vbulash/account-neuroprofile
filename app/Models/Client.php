<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Клиент
 *
 * @property string $name
 * @property string $inn
 * @property string $ogrn
 * @property string $address
 * @property string $phone
 * @property string $email
 */
class Client extends Model implements Titleable {
    use HasFactory;

    protected $fillable = [
        'name',
        'inn',
        'ogrn',
        'address',
        'phone',
        'email'
    ];

    public function getTitle(): string {
        return $this->name;
    }

    public function contracts(): HasMany {
        return $this->hasMany(Contract::class);
    }
}
