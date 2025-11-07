<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Courier
 * 
 * @property int $id
 * @property int $user_id
 * @property int $branch_id
 * @property string $fullname
 * @property string $address
 * @property string $phone_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property User $user
 * @property Collection|Delivery[] $deliveries
 *
 * @package App\Models
 */
class Courier extends Model
{
	protected $table = 'couriers';

	protected $casts = [
		'user_id' => 'int',
		'branch_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'branch_id',
		'fullname',
		'address',
		'phone_number'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}
}
