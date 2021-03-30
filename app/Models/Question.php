<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'image', 'answer1', 'answer2', 'answer3', 'answer4', 'correct_answer'];

    protected $appends = ['true_percent'];

    public function getTruePercentAttribute()
    {
        $answersCount = $this->answers()->count();
        $trueCount = $this->answers()->where('answer', $this->correct_answer)->count();

        return round((100 / $answersCount) * $trueCount);
    }

    /**
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    /**
     * @return HasOne
     */
    public function myAnswer()
    {
        return $this->hasOne('App\Models\Answer')->where('user_id', auth()->user()->id);
    }
}
