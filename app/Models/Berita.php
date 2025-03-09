<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Berita
 * 
 * @property int $idBerita
 * @property string|null $judul_berita
 * @property Carbon $tgl_berita
 * @property string|null $author_id
 * @property string|null $url_gambar
 * @property string|null $isi_berita
 * @property string|null $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Berita extends Model
{
	protected $connection = 'mysql';
	protected $table = 'berita';
	protected $primaryKey = 'idBerita';

	protected $casts = [
		'tgl_berita' => 'datetime'
	];

	protected $fillable = [
		'judul_berita',
		'tgl_berita',
		'author_id',
		'url_gambar',
		'isi_berita',
		'slug'
	];
}
