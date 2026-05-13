<?php

namespace Azuriom\Plugin\Staff\Models;

use Azuriom\Models\Traits\Attachable;
use Azuriom\Models\Traits\HasImage;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 *
 * @property int $id
 * @property string|null $image
 * @property string $name
 * @property string description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Staff extends Model
{
    use Attachable;
    use HasImage;
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'staff_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'position'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['position' => 'integer'];

    /**
     * Get all of the tags for the staff.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'staff_taggables')->orderBy('position');
    }

    public function user()
    {
        if (User::where('name', $this->name)->first()) {
            $user = User::where('name', $this->name)->first()->role();
        } else {
            $user = '';
        }

        return $user;
    }

    /**
     * Get all of the links for the staff.
     */
    public function links()
    {
        return $this->hasMany(Link::class)->orderBy('position');
    }

    public function isSelected($id)
    {
        if (! ($ids = old('tags'))) {
            $ids = $this->tags->pluck('id');
        }

        return collect($ids)->contains($id) ? 'selected' : '';
    }
}
