<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 *
 * @property integer        $id
 * @property string         $name
 * @property array          $settings
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
    protected $fillable = ['name', 'settings'];

    protected $casts = [
        'name'     => 'string',
        'settings' => 'array',
    ];

    public function scopeSettings(Builder $query){
        $settings = $query->where('id', 1)->first();
       return json_decode($settings);
    }


    public function setSettingsAttribute($array)
    {
        $this->attributes['settings'] = json_encode($array);
    }
}
