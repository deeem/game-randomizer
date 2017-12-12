<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'platform_id'];

    /**
     * Get the user that approved game
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get game platform
     */
    public function platform()
    {
        return $this->belongsTo('App\Platform');
    }
}
