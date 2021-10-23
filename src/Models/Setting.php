<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 *
 * @property integer        $id
 * @property string         $name
 * @property object         $setting
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package Azuriom\Plugin\Staff\Models
 */
class Setting extends Model
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
    protected $fillable = ['name', 'setting'];

    protected $casts = [
        'setting' => 'object'
    ];

}
