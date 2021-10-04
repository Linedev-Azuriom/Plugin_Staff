<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 *
 * @property integer $id
 * @property string  $name
 * @property string  $url
 * @property string  $icon
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Link extends Model
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
    protected $fillable = ['name', 'url', 'icon'];

    /**
     * Get all of the staff that are assigned this links.
     */
    public function staffs()
    {
        return $this->belongsTo(Staff::class);
    }
}
