<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderDetail
 * 
 * @property int $id
 * @property int $order_id
 * @property int $menu_id
 * @property int $quantity
 * @property float $sub_total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Menu $menu
 * @property Order $order
 *
 * @package App\Models
 */
class OrderDetail extends Model
{
	protected $table = 'order_details';

	protected $casts = [
		'order_id' => 'int',
		'menu_id' => 'int',
		'quantity' => 'int',
		'sub_total' => 'float'
	];

	protected $fillable = [
		'order_id',
		'menu_id',
		'quantity',
		'sub_total'
	];

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
