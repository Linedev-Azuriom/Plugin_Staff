<?php

namespace Azuriom\Plugin\Staff\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @property integer $id
 * @property string $name
 * @property string $color
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Tag extends Model
{
    protected $prefix = 'staffs_';
    protected $fillable = ['name', 'color'];

    /**
     * Get all of the staff that are assigned this tag.
     */
    public function staffs()
    {
        return $this->morphedByMany(Staff::class, 'taggable');
    }

}
