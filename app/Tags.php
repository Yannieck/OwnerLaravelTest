<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tags extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    protected $table = 'tags';

    /**
     * The product that have the tag
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
