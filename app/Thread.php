<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });
        static::addGlobalScope('channel', function ($builder) {
            $builder->with('channel');
        });
    }

    /**
     * Fetch path to the current thread
     *
     * @return string
     */
    public function getPath(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class)->withCount('favorites');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @param $replay
     */
    public function addReplay($replay)
    {
        $this->replies()->create($replay);
    }

    /**
     * @param $query
     * @param ThreadFilters $filters
     * @return mixed
     */
    public static function filter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }
}
