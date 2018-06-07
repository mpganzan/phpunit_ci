<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Article extends Model
{
    protected $guarded = [];

    /**
     * Get the article owner details
     *
     * @return Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the article comments
     *
     * @return Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Custom accessor for created_at attribute
     *
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * Get the article excerpt
     *
     * @return string
     */
    public function excerpt()
    {
        return str_limit($this->content, 240);
    }
}
