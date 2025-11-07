<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionScheduleDetail
 * 
 * @property int $id
 * @property int $production_schedule_id
 * @property Carbon $schedule_date
 * @property int $menu_id
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Menu $menu
 * @property ProductionSchedule $production_schedule
 *
 * @package App\Models
 */
class ProductionScheduleDetail extends Model
{
	protected $table = 'production_schedule_details';

	protected $casts = [
		'production_schedule_id' => 'int',
		'schedule_date' => 'datetime',
		'menu_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'production_schedule_id',
		'schedule_date',
		'menu_id',
		'quantity'
	];

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function production_schedule()
	{
		return $this->belongsTo(ProductionSchedule::class);
	}
}
