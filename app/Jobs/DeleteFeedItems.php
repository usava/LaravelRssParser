<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteFeedItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lists;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lists)
    {
        $this->lists = $lists;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->lists as $value) {
            DB::table('feed_items')->where('id', $value)->delete();
        }
    }
}
