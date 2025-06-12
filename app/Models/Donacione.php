<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donacione
 * 
 * @property int $id
 * @property int $user_id
 * @property int $centro_id
 * @property int|null $cita_id
 * @property string $tipo_sangre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Centro $centro
 * @property Cita|null $cita
 * @property User $user
 *
 * @package App\Models
 */
class Donacione extends Model
{
	protected $table = 'donaciones';

	protected $casts = [
		'user_id' => 'int',
		'centro_id' => 'int',
		'cita_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'centro_id',
		'cita_id',
		'tipo_sangre'
	];

	public function centro()
	{
		return $this->belongsTo(Centro::class);
	}

	public function cita()
	{
		return $this->belongsTo(Cita::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
