<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Branch
 * 
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $province
 * @property int $open
 * @property int $close
 * @property string $phone_number
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Courier[] $couriers
 * @property Collection|Employee[] $employees
 * @property Collection|IngredientsHistory[] $ingredients_histories
 * @property Collection|Manager[] $managers
 * @property Collection|Menu[] $menus
 * @property Collection|Order[] $orders
 * @property Collection|ProductionSchedule[] $production_schedules
 * @property Collection|Production[] $productions
 *
 * @package App\Models
 */
class Branch extends Model
{
	protected $table = 'branchs';

	protected $casts = [
		'open' => 'int',
		'close' => 'int'
	];

	protected $fillable = [
		'name',
		'address',
		'city',
		'province',
		'open',
		'close',
		'phone_number',
		'email'
	];

	public function couriers()
	{
		return $this->hasMany(Courier::class);
	}

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}

	public function ingredients_histories()
	{
		return $this->hasMany(IngredientsHistory::class);
	}

	public function managers()
	{
		return $this->hasMany(Manager::class);
	}

	public function menus()
	{
		return $this->hasMany(Menu::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function production_schedules()
	{
		return $this->hasMany(ProductionSchedule::class);
	}

	public function productions()
	{
		return $this->hasMany(Production::class);
	}
}
