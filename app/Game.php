<?php

namespace App;

use DB;
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
     * Get game suggester
     */
    public function suggester()
    {
        return $this->belongsTo('App\Suggester');
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

    /**
     * Scope a query to only include approved games.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('user_id', '!=', null);
    }

    /**
     * Scope a query to recent approved games
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecentApproved($query)
    {
        return $query->where('user_id', '!=', null)->latest('updated_at');
    }

    /**
     * Scope a query to get top suggesters
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
     public function scopeTopSuggesters($query)
     {
         return DB::table('games')
            ->join('suggesters', 'games.suggester_id', '=', 'suggesters.id')
            ->select(DB::raw('count(games.suggester_id) as suggester_count, suggesters.name'))
            ->groupBy('games.suggester_id')
            ->orderBy('suggester_count', 'desc');
     }

    /**
     * Scope a query to get top approvers
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
     public function scopeTopApprovers($query)
     {
         return DB::table('games')
            ->join('users', 'games.user_id', '=', 'users.id')
            ->select(DB::raw('count(games.user_id) as approver_count, users.name'))
            ->groupBy('games.user_id')
            ->orderBy('approver_count', 'desc');
     }
}
