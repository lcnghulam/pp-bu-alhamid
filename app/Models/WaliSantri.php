<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WaliSantri
 * 
 * @property int $id
 * @property string|null $nama
 * @property string|null $no_hp
 * @property string|null $alamat
 * @property string|null $status
 * @property int|null $idSantri
 *
 * @package App\Models
 */
class WaliSantri extends Model
{
	protected $connection = 'mysql';
	protected $table = 'wali_santri';
	public $timestamps = false;

	protected $casts = [
		'idSantri' => 'int'
	];

	protected $fillable = [
		'nama',
		'no_hp',
		'alamat',
		'status',
		'idSantri'
	];
}
