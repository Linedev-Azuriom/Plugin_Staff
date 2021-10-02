<?php

namespace Azuriom\Plugin\Staff\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $icon
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Link extends Model
{

    protected $prefix = 'staffs_';
    protected $fillable = ['name', 'url', 'icon'];

    /**
     * Get all of the staff that are assigned this links.
     */
    public function staffs()
    {
        return $this->morphedByMany(Staff::class, 'linkable');
    }
}
