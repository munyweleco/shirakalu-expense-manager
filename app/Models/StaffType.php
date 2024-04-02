<?php

namespace App\Models;

use App\Models\Base\StaffType as BaseStaffType;

class StaffType extends BaseStaffType
{
	protected $hidden = [
		'active'
	];

	protected $fillable = [
		'staff_type_name',
		'active'
	];
}
