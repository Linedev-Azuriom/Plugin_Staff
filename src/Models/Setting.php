<?php

namespace Azuriom\Plugin\Staff\Models;


use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Staff
 *
 * @property integer $id
 * @property string $name
 * @property object $settings
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
        'settings' => 'array'
    ];


    public function setSettingsAttribute($value)
    {
        $settings = [];
        foreach ($value as $array_item) {
            $settings[] = $array_item;
        }
        dump($settings);
        die();

        $this->attributes['settings'] = json_encode($settings);
    }
}
