<?php

namespace Azuriom\Plugin\Staff\Models;


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
    protected $prefix = 'staff_';
    protected $fillable = ['avatar', 'pseudo', 'description'];

    /**
     * Get all of the tags for the staff.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get all of the links for the staff.
     */
    public function links()
    {
        return $this->morphToMany(Link::class, 'linkable');
    }
}
