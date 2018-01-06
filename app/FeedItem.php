<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedItem extends Model
{
    protected $fillable = ['feed_id', 'title', 'link', 'description', 'pubDate'];
}
