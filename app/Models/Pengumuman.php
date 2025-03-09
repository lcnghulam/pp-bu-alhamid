<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pengumuman
 * 
 * @property int $idPengumuman
 * @property string|null $judul_pengumuman
 * @property Carbon|null $tgl_pengumuman
 * @property string|null $author_id
 * @property string|null $url_gambar
 * @property string|null $isi_pengumuman
 * @property string|null $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Pengumuman extends Model
{
	protected $connection = 'mysql';
	protected $table = 'pengumuman';
	protected $primaryKey = 'idPengumuman';

	protected $casts = [
		'tgl_pengumuman' => 'datetime'
	];

	protected $fillable = [
		'judul_pengumuman',
		'tgl_pengumuman',
		'author_id',
		'url_gambar',
		'isi_pengumuman',
		'slug'
	];
}
