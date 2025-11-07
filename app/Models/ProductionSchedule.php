<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionSchedule
 * 
 * @property int $id
 * @property int $branch_id
 * @property Carbon $schedule_date
 * @property int $manager_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Branch $branch
 * @property Manager $manager
 * @property Collection|ProductionScheduleDetail[] $production_schedule_details
 *
 * @package App\Models
 */
class ProductionSchedule extends Model
{
	protected $table = 'production_schedules';

	protected $casts = [
		'branch_id' => 'int',
		'schedule_date' => 'datetime',
		'manager_id' => 'int'
	];

	protected $fillable = [
		'branch_id',
		'schedule_date',
		'manager_id'
	];

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function manager()
	{
		return $this->belongsTo(Manager::class);
	}

	public function production_schedule_details()
	{
		return $this->hasMany(ProductionScheduleDetail::class);
	}
}
