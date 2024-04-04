<?php

namespace App\Models;

use App\Models\Base\StaffType as BaseStaffType;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
class StaffType extends BaseStaffType
{
	protected $fillable = [
		'name',
		'description',
		'active'
	];
}
