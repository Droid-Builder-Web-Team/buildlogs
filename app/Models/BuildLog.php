<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\HasTags;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Maize\Markable\Models\Bookmark;

/**
 * App\Models\BuildLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property \Illuminate\Database\Eloquent\Collection<int, \Spatie\Tags\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereHasMark(\Maize\Markable\Mark $mark, \Illuminate\Database\Eloquent\Model $user, ?string $value = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog withAllTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog withAllTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog withAnyTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog withAnyTagsOfAnyType($tags)
 * @method static \Illuminate\Database\Eloquent\Builder|BuildLog withoutTags(\ArrayAccess|\Spatie\Tags\Tag|array|string $tags, ?string $type = null)
 * @mixin \Eloquent
 */
class BuildLog extends Model
{
    use HasFactory;
    use HasTags;
    use Markable;

    protected $guarded = [];

    protected static $marks = [
        Like::class,
        Bookmark::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function num_posts(): int
    {
        return $this->posts()->count();
    }

    public function last_post()
    {
        if ($this->num_posts() > 0) {
            return $this->posts()->first()->created_at->format('d/m/Y H:i:s');
        } else {
            return "No Posts";
        }
    }    

    public function type()
    {
        return $this->tagsWithType('droidtype');
    }      

    public function material()
    {
        return $this->tagsWithType('material');
    }       

    public function likes()
    {
        return Like::count($this);
    }
}
