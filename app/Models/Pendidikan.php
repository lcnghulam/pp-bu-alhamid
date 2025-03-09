<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pendidikan
 * 
 * @property int $id
 * @property string|null $nama_pendidikan
 * @property string|null $jenis_pendidikan
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Pendidikan extends Model
{
	protected $connection = 'mysql';
	protected $table = 'pendidikan';

	protected $fillable = [
		'nama_pendidikan',
		'jenis_pendidikan'
	];
}
