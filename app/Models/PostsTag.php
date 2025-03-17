<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostsTag
 * 
 * @property int $id
 * @property string|null $tags
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|PostsRelation[] $posts_relations
 *
 * @package App\Models
 */
class PostsTag extends Model
{
	protected $connection = 'mysql';
	protected $table = 'posts_tag';

	protected $fillable = [
		'tag'
	];

	public function posts_relations()
	{
		return $this->hasMany(PostsRelation::class, 'tag_id');
	}
}
