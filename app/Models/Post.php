<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $author_id
 * @property string|null $post_judul
 * @property Carbon|null $post_date
 * @property string|null $post_category
 * @property string|null $post_img
 * @property string|null $post_isi
 * @property string|null $post_status
 * @property string|null $slug
 * @property int|null $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|PostsRelation[] $posts_relations
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $connection = 'mysql';
	protected $table = 'posts';

	protected $casts = [
		'post_date' => 'datetime',
		'views' => 'int'
	];

	protected $fillable = [
		'author_id',
		'post_judul',
		'post_date',
		'post_category',
		'post_img',
		'post_isi',
		'post_status',
		'slug',
		'views'
	];

	public function author()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function posts_relations()
	{
		return $this->hasMany(PostsRelation::class);
	}
}
