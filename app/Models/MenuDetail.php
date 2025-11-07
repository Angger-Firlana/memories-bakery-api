<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MenuDetail
 * 
 * @property int $id
 * @property int $menu_id
 * @property int $ingredient_id
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ingredient $ingredient
 * @property Menu $menu
 *
 * @package App\Models
 */
class MenuDetail extends Model
{
	protected $table = 'menu_details';

	protected $casts = [
		'menu_id' => 'int',
		'ingredient_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'menu_id',
		'ingredient_id',
		'quantity'
	];

	public function ingredient()
	{
		return $this->belongsTo(Ingredient::class);
	}

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}
}
