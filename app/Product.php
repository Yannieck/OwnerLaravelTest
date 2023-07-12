<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    protected $table = 'products';

    /**
     * The product that have the tag
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tags::class);
    }
}
