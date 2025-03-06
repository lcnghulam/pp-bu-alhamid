<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Santri
 * 
 * @property int $id
 * @property int|null $nis
 * @property string|null $nama_lengkap
 * @property Carbon|null $ttl
 * @property string|null $gender
 * @property string|null $no_hp
 * @property string|null $alamat
 * 
 * @property Collection|WaliSantri[] $wali_santris
 *
 * @package App\Models
 */
class Santri extends Model
{
	protected $connection = 'mysql';
	protected $table = 'santri';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'nis' => 'int',
		'ttl' => 'datetime'
	];

	protected $fillable = [
		'nis',
		'nama_lengkap',
		'ttl',
		'gender',
		'no_hp',
		'alamat'
	];

	public function wali_santris()
	{
		return $this->hasMany(WaliSantri::class, 'idSantri');
	}
}
