<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NivelReserva
 * 
 * @property int $id
 * @property string $tipo_sangre
 * @property int $cantidad
 * @property string $nivel
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class NivelReserva extends Model
{
	protected $table = 'nivel_reserva';

	protected $casts = [
		'cantidad' => 'int'
	];

	protected $fillable = [
		'tipo_sangre',
		'cantidad',
		'nivel'
	];
}
