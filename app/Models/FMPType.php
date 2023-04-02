<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FMPType extends Model {
	use HasFactory;

	protected $table = 'fmptypes';

	public function profiles(): HasMany {
		return $this->hasMany(Profile::class, 'fmptype_id');
	}
}