<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Santri
 * 
 * @property int $nis
 * @property string|null $nama_lengkap
 * @property string|null $tempat_lahir
 * @property Carbon|null $tgl_lahir
 * @property string|null $gender
 * @property string|null $email
 * @property string|null $no_hp
 * @property string|null $alamat
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Santri extends Model
{
	protected $connection = 'mysql';
	protected $table = 'santri';
	protected $primaryKey = 'nis';
	public $incrementing = false;

	protected $casts = [
		'tgl_lahir' => 'datetime'
	];

	protected $fillable = [
		'nis',
		'nik',
		'foto',
		'nama_lengkap',
		'tempat_lahir',
		'tgl_lahir',
		'gender',
		'email',
		'no_hp',
		'alamat',
		'tgl_masuk',
		'tgl_keluar'
	];
}
