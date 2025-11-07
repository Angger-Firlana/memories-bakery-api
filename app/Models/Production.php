<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Production
 * 
 * @property int $id
 * @property int $menu_id
 * @property int $branch_id
 * @property Carbon $date_production
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Menu $menu
 *
 * @package App\Models
 */
class Production extends Model
{
	protected $table = 'productions';

	protected $casts = [
		'menu_id' => 'int',
		'branch_id' => 'int',
		'date_production' => 'datetime',
		'quantity' => 'int'
	];

	protected $fillable = [
		'menu_id',
		'branch_id',
		'date_production',
		'quantity'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}
}
