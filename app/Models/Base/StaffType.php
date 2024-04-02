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
 * @property string $staff_type_name
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class StaffType extends Model
{
	protected $table = 'staff_type';

	protected $casts = [
		'active' => 'int'
	];
}
