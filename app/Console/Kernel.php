<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $url = config('feedreader.breaking_news_url');
            $rss = \App\FeedReader::loadRss($url);

            $feed = new \App\Feed();
            $feed->title = $rss->title;
            $feed->link = $url;
            $feed->description = $rss->description;

            $feed = $feed->firstOrCreate($feed->toArray());

            foreach($rss->item as $item){
                $feed_item = new \App\FeedItem();
                $feed_item->feed_id = $feed->id;
                $feed_item->title = $item->title;
                $feed_item->link = $item->link;
                $feed_item->description = $item->description;
                $feed_item->pubDate = $item->pubDate;

                $feed_item->updateOrCreate($feed_item->toArray());
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
