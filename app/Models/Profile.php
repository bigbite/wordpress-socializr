<?php

namespace Socializr\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
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
    protected $table = 'socializr_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url', 'handle'];

    /**
     * The set this profile belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function set()
    {
        return $this->belongsTo(__NAMESPACE__ . '\\Set');
    }
}
