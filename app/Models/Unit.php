<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Unit
 * 
 * @property int $id
 * @property string $unit_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Ingredient[] $ingredients
 *
 * @package App\Models
 */
class Unit extends Model
{
	protected $table = 'units';

	protected $fillable = [
		'unit_name'
	];

	public function ingredients()
	{
		return $this->hasMany(Ingredient::class);
	}
}
