<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class IngredientsHistory
 * 
 * @property int $id
 * @property int $branch_id
 * @property Carbon $received_date
 * @property int $quantity
 * @property Carbon $expired_date
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 *
 * @package App\Models
 */
class IngredientsHistory extends Model
{
	protected $table = 'ingredients_history';

	protected $casts = [
		'branch_id' => 'int',
		'received_date' => 'datetime',
		'quantity' => 'int',
		'expired_date' => 'datetime'
	];

	protected $fillable = [
		'branch_id',
		'received_date',
		'quantity',
		'expired_date',
		'status'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}
}
