<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 * 
 * @property int $id
 * @property int $type_id
 * @property int $branch_id
 * @property string $name
 * @property float $price
 * @property int $validDuration
 * @property int $stock
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Type $type
 * @property Collection|MenuDetail[] $menu_details
 * @property Collection|OrderDetail[] $order_details
 * @property Collection|Order[] $orders
 * @property Collection|ProductionScheduleDetail[] $production_schedule_details
 * @property Collection|Production[] $productions
 *
 * @package App\Models
 */
class Menu extends Model
{
	protected $table = 'menus';
	protected $appends = ['photo_url'];

	protected $casts = [
		'type_id' => 'int',
		'branch_id' => 'int',
		'price' => 'float',
		'validDuration' => 'int',
		'stock' => 'int'
	];

	protected $fillable = [
		'type_id',
		'branch_id',
		'name',
		'description',
		'price',
		'photo',
		'validDuration',
		'stock'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function type()
	{
		return $this->belongsTo(Type::class);
	}
	public function getPhotoUrlAttribute()
	{
		if ($this->photo) {
			return asset('storage/' . $this->photo);
		}
		return null;
	}

	public function menu_details()
	{
		return $this->hasMany(MenuDetail::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function production_schedule_details()
	{
		return $this->hasMany(ProductionScheduleDetail::class);
	}

	public function productions()
	{
		return $this->hasMany(Production::class);
	}
}
