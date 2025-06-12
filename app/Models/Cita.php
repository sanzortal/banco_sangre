<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cita
 * 
 * @property int $id
 * @property int $user_id
 * @property int $centro_id
 * @property Carbon $fecha
 * @property string $estado
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Centro $centro
 * @property User $user
 *
 * @package App\Models
 */
class Cita extends Model
{
	protected $table = 'citas';

	protected $casts = [
		'user_id' => 'int',
		'centro_id' => 'int',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'centro_id',
		'fecha',
		'estado'
	];

	public function centro()
	{
		return $this->belongsTo(Centro::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
