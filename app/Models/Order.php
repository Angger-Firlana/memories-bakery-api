<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property int $branch_id
 * @property int $menu_id
 * @property int $customer_id
 * @property int $employee_id
 * @property Carbon $orderDate
 * @property string $address
 * @property string $phoneNumber
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Customer $customer
 * @property Employee $employee
 * @property Menu $menu
 * @property Collection|Delivery[] $deliveries
 * @property Collection|OrderDetail[] $order_details
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'branch_id' => 'int',
		'menu_id' => 'int',
		'customer_id' => 'int',
		'employee_id' => 'int',
		'orderDate' => 'datetime'
	];

	protected $fillable = [
		'branch_id',
		'menu_id',
		'customer_id',
		'employee_id',
		'orderDate',
		'address',
		'phoneNumber',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class);
	}

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}

	public function order_details()
	{
		return $this->hasMany(OrderDetail::class);
	}
}
