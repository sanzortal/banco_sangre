<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donante
 * 
 * @property int $id
 * @property int $user_id
 * @property string $tipo_sangre
 * @property Carbon|null $fecha_nacimiento
 * @property string|null $telefono
 * @property string|null $direccion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Donante extends Model
{
	protected $table = 'donantes';

	protected $casts = [
		'user_id' => 'int',
		'fecha_nacimiento' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'tipo_sangre',
		'fecha_nacimiento',
		'telefono',
		'direccion',
		'sexo'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
