<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    protected $fillable = ['title', 'link', 'description'];

    public function items()
    {
        return $this->hasMany('\App\FeedItem', 'feed_id');
    }
}
