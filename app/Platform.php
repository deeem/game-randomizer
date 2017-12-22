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
    protected $fillable = ['name', 'slug'];

    /**
     * Get games for this platform
     */
    public function games()
    {
        return $this->hasMany('App\Game');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get statistic of added games by platforms
     *
     * @return \Illuminate\Support\Collection
     */
    public static function gamesStats()
    {
        $stats = [];
        $platforms = self::all();
        foreach($platforms as $platform) {
            $stats[] = ['name' => $platform->name, 'gamesCount' => $platform->games->count()];
        }

        return collect($stats);
    }
}
