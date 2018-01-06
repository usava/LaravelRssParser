<?php

namespace App\Http\Controllers;

use App\Feed;


class IndexController extends Controller
{
    public function execute()
    {
        $url = config('feedreader.breaking_news_url');

        $feed = Feed::where('link', $url)->first();
        $feed_items = $feed->items()->paginate(5);

        return view('index', compact('feed', 'feed_items'));
    }
}
