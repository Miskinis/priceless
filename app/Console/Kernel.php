<?php

namespace App\Console;

use App\Crawlers\PriceObserver;
use App\Models\ProductStore;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Crawler\Crawler;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            foreach (ProductStore::all() as $productStore) {
                if (!is_null($productStore->url) && !is_null($productStore->price_xpath))
                    //# initiate crawler
                    Crawler::create([RequestOptions::ALLOW_REDIRECTS => true, RequestOptions::TIMEOUT => 30])
                        ->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36 Edge/12.246')
                        ->acceptNofollowLinks()
                        ->ignoreRobots()
//                ->setParseableMimeTypes(['text/html', 'text/plain'])
                        ->setCrawlObserver(new PriceObserver($productStore))
//                ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
                        ->setTotalCrawlLimit(1) // limit defines the maximal count of URLs to crawl
//                ->setConcurrency(1) // all urls will be crawled one by one
                        ->setDelayBetweenRequests(100)
//                ->executeJavaScript()
                        ->startCrawling($productStore->url);
            }
        })->daily();
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
