<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StaffType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models\Base
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType query()
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StaffType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StaffType extends Model
{
	protected $table = 'staff_type';

	protected $casts = [
		'active' => 'bool'
	];
}
