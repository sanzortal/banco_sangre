<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\HorariosCentro;

/**
 * Class Centro
 * 
 * @property int $id
 * @property int $user_id
 * @property string|null $telefono
 * @property string|null $direccion
 * @property float|null $latitud
 * @property float|null $longitud
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Centro extends Model
{
	protected $table = 'centros';

	protected $casts = [
		'user_id' => 'int',
		'latitud' => 'float',
		'longitud' => 'float'
	];

	protected $fillable = [
		'user_id',
		'telefono',
		'direccion',
		'latitud',
		'longitud'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function horarios()
	{
		return $this->hasMany(HorariosCentro::class);
	}

}
