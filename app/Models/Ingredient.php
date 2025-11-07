<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ingredient
 * 
 * @property int $id
 * @property int $unit_id
 * @property string $name
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Unit $unit
 * @property Collection|MenuDetail[] $menu_details
 *
 * @package App\Models
 */
class Ingredient extends Model
{
	protected $table = 'ingredients';

	protected $casts = [
		'unit_id' => 'int',
		'price' => 'float'
	];

	protected $fillable = [
		'unit_id',
		'name',
		'price'
	];

	public function unit()
	{
		return $this->belongsTo(Unit::class);
	}

	public function menu_details()
	{
		return $this->hasMany(MenuDetail::class);
	}
}
