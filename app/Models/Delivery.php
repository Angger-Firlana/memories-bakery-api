<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delivery
 * 
 * @property int $id
 * @property int $order_id
 * @property int $courier_id
 * @property string $address
 * @property float $fee
 * @property Carbon $delivery_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Courier $courier
 * @property Order $order
 *
 * @package App\Models
 */
class Delivery extends Model
{
	protected $table = 'deliveries';

	protected $casts = [
		'order_id' => 'int',
		'courier_id' => 'int',
		'fee' => 'float',
		'delivery_date' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'courier_id',
		'address',
		'fee',
		'delivery_date',
		'status'
	];

	public function courier()
	{
		return $this->belongsTo(Courier::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
