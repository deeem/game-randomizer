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
    protected $fillable = ['name', 'platform_id', 'suggested'];

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

    /**
     * Scope a query to only include unapproved games.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnapproved($query)
    {
        return $query->where('user_id', '=', null);
    }
}
