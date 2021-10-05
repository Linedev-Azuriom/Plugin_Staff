<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @property integer $id
 * @property string  $name
 * @property string  $color
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Tag extends Model
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
    protected $fillable = ['name', 'color'];

    /**
     * Get all of the staff that are assigned this tag.
     */
    public function staffs()
    {
        return $this->morphedByMany(Staff::class, 'taggable');
    }
}
