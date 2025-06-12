<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Centro;

/**
 * Class HorariosCentro
 * 
 * @property int $id
 * @property int $centro_id
 * @property string $dia_semana
 * @property Carbon|null $hora_inicio
 * @property Carbon|null $hora_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Centro $centro
 *
 * @package App\Models
 */
class HorariosCentro extends Model
{
	protected $table = 'horarios_centros';

	protected $casts = [
		'centro_id' => 'int',
		'hora_inicio' => 'datetime',
		'hora_fin' => 'datetime'
	];

	protected $fillable = [
		'centro_id',
		'dia_semana',
		'hora_inicio',
		'hora_fin',
		'aforo',
		'duracion_bloque',
	];

	public function centro()
	{
		return $this->belongsTo(Centro::class);
	}
}
