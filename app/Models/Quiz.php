<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;

class Quiz extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'description', 'status', 'finished_at'];

    protected $dates = ['finished_at'];

    protected $appends = ['details', 'myRank'];

    /**
     * @return array
     */
    public function getDetailsAttribute()
    {
        return [
            'average' => round($this->results()->avg('score')),
            'joiner_count' => $this->results()->count(),
        ];
    }

    public function getMyRankAttribute()
    {
        $rank = 0;
        foreach ($this->results()->orderByDesc('score')->get() as $result){
            $rank += 1;
            if(Auth::user()->id == $result->user_id && $rank > 10){
                return $rank;
            }
        }
    }

    /**
     * @param $date
     * @return Carbon|null
     */
    public function getFinishedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    /**
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    /**
     * @return HasMany
     */
    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function topTen()
    {
        return $this->results()->orderByDesc('score')->take(10);
    }

    /**
     * @return HasOne
     */
    public function myResult()
    {
        return $this->hasOne('App\Models\Result')->where('user_id', auth()->user()->id);
    }

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'onUpdate' => true,
                'source' => 'title'
            ]
        ];
    }
}
