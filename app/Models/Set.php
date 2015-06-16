<?php

namespace Socializr\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'socializr_sets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'type'];

    /**
     * The shares that this set contains.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function shares()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Share', 'socializr_sets_shares', 'set_id', 'share_id');
    }

    /**
     * The profiles that this set contains.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profile()
    {
        return $this->hasMany(__NAMESPACE__ . '\\Profile');
    }
}
