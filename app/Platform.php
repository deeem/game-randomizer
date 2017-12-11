<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get games for this platform
     */
    public function games()
    {
        return $this->hasMany('App\Game');
    }

}
