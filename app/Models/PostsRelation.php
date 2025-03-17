<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostsRelation
 * 
 * @property int $id
 * @property int|null $post_id
 * @property int|null $subcategory_id
 * @property int|null $tag_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Post|null $post
 * @property PostsSubcategory|null $posts_subcategory
 * @property PostsTag|null $posts_tag
 *
 * @package App\Models
 */
class PostsRelation extends Model
{
	protected $connection = 'mysql';
	protected $table = 'posts_relation';

	protected $casts = [
		'post_id' => 'int',
		'subcategory_id' => 'int',
		'tag_id' => 'int'
	];

	protected $fillable = [
		'post_id',
		'subcategory_id',
		'tag_id'
	];

	public function post()
	{
		return $this->belongsTo(Post::class, 'post_id');
	}

	public function posts_subcategory()
	{
		return $this->belongsTo(PostsSubcategory::class, 'subcategory_id');
	}

	public function posts_tag()
	{
		return $this->belongsTo(PostsTag::class, 'tag_id');
	}
}
