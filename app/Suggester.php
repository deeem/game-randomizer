<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggester extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * Get games suggested by that suggester
     */
    public function games()
    {
        return $this->hasMany('App\Game');
    }
}
