<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttachmentPengumuman
 * 
 * @property int $id
 * @property string|null $filename
 * @property string|null $directory
 * @property int|null $pengumuman_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class AttachmentPengumuman extends Model
{
	protected $connection = 'mysql';
	protected $table = 'attachment_pengumuman';

	protected $casts = [
		'pengumuman_id' => 'int'
	];

	protected $fillable = [
		'filename',
		'directory',
		'pengumuman_id'
	];
}
