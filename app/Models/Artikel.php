<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artikel
 * 
 * @property int $id
 * @property string|null $judul_artikel
 * @property Carbon $tgl_artikel
 * @property string|null $author_id
 * @property string|null $url_gambar
 * @property string|null $isi_artikel
 * @property string|null $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Artikel extends Model
{
	protected $connection = 'mysql';
	protected $table = 'artikel';

	protected $casts = [
		'tgl_artikel' => 'datetime'
	];

	protected $fillable = [
		'judul_artikel',
		'tgl_artikel',
		'author_id',
		'url_gambar',
		'isi_artikel',
		'slug'
	];
}
