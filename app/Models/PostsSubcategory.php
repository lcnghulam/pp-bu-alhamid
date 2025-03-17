<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostsSubcategory
 * 
 * @property int $id
 * @property string|null $sub_category
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|PostsRelation[] $posts_relations
 *
 * @package App\Models
 */
class PostsSubcategory extends Model
{
	protected $connection = 'mysql';
	protected $table = 'posts_subcategory';

	protected $fillable = [
		'sub_category'
	];

	public function posts_relations()
	{
		return $this->hasMany(PostsRelation::class, 'subcategory_id');
	}
}
