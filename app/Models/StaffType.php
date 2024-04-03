<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffType
 *
 * @property int $id
 * @property string $staff_type_name
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereStaffTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaffType extends Model
{
	protected $table = 'staff_type';

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'staff_type_name',
		'active'
	];
}
