<?php

namespace Socializr\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
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
    protected $table = 'socializr_shares';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'url', 'default_set'];

    /**
     * The sets that this link is in.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sets()
    {
        return $this->belongsToMany(__NAMESPACE__ . '\\Set', 'socializr_sets_shares', 'share_id', 'set_id');
    }
}
