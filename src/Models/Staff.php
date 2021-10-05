<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 *
 * @property integer $id
 * @property string $avatar
 * @property string $pseudo
 * @property string description
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Staff extends Model
{
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
    protected $fillable = ['avatar', 'pseudo', 'description'];

    /**
     * Get all of the tags for the staff.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'staff_taggables');
    }


    /**
     * Get all of the links for the staff.
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }

    function isSelected($id)
    {
        if (!($ids = old('tags'))) {
            $ids = $this->tags->pluck('id');
        }
        return collect($ids)
            ->contains($id) ? 'selected' : '';
    }
}
