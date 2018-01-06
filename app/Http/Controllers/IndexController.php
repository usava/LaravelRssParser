<?php

namespace App\Http\Controllers;

use App\Feed;
use App\FeedItem;
use App\Jobs\DeleteFeedItems;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function execute()
    {
        $url = config('feedreader.breaking_news_url');

        $feed = Feed::where('link', $url)->first();
        $feed_items = $feed->items()->paginate(5);

        return view('index', compact('feed', 'feed_items'));
    }

    public function deleteNews($feed_id, Request $request)
    {
        if($request->isMethod('delete')) {
            $lists = FeedItem::where('feed_id', $feed_id)->pluck('id')->toArray();
            $jobs = (new DeleteFeedItems($lists));
            $this->dispatch($jobs);

            return redirect('/')->with('status', 'NewsItems successful sent to delete.');
        }

        return abort(404);
    }
}
