<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Centro;
use App\Models\Donante;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Centro|null $centro
 * @property Donante|null $donante
 *
 * @package App\Models
 */
class User extends Authenticatable 
{
	use HasApiTokens, Notifiable;

	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password' => 'hashed',
		'role' => UserRole::class
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'role',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function centro()
	{
		return $this->hasOne(Centro::class);
	}

	public function donante()
	{
		return $this->hasOne(Donante::class);
	}

    public function esDonante()
	{
		return $this->role === 'donante';
	}

    public function esAdmin()
	{
		return $this->role === 'admin';
	}

    public function esCentro()
	{
		return $this->role === 'centro';
	}

	public function initials(): string
	{
		$words = explode(' ', $this->name);
		$initials = '';

		foreach ($words as $word) {
			$initials .= strtoupper(substr($word, 0, 1));
		}

		return $initials;
	}
}
