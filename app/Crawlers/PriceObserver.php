<?php

namespace App\Crawlers;

use App\Models\ProductStore;
use DOMDocument;
use DOMXPath;
use Psr\Http\Message\UriInterface;
use Illuminate\Support\Facades\Log;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class PriceObserver extends CrawlObserver
{
    private $price;
    private ProductStore $model;

    public function __construct($model) {
        $this->model = $model;
        $this->price = null;
    }

    /**
     * Called when the crawler will crawl the url.
     *
     * @param UriInterface $url
     */
    public function willCrawl(UriInterface $url): void
    {
        Log::info('willCrawl', ['url' => $url]);
    }


    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param UriInterface $url
     * @param ResponseInterface $response
     * @param UriInterface|null $foundOnUrl
     */
    public function crawled(UriInterface $url, ResponseInterface $response, ?UriInterface $foundOnUrl = null): void
    {
        $doc = new DOMDocument();
        @$doc->loadHTML($response->getBody());

        $xpath = new DOMXPath($doc);

        $priceQuery = $xpath->query($this->model->price_xpath);
        foreach ($priceQuery as $item)
        {
            Log::info("Content: " . $item->textContent);
            $this->price = $item->textContent;
        }
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param UriInterface $url
     * @param RequestException $requestException
     * @param UriInterface|null $foundOnUrl
     */
    public function crawlFailed(UriInterface $url, RequestException $requestException, ?UriInterface $foundOnUrl = null): void
    {
        Log::error('crawlFailed',['url'=>$url,'error'=>$requestException->getMessage()]);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        if (!is_null($this->price))
            $this->model->update([
                'price' => new \Whitecube\LaravelPrices\Models\Price(
                    amount: floatval($this->price),
                    currency: $this->model->priceCurrency,
                    type: 'selling',
                    activated_at: now())
            ]);
        Log::info("finishedCrawling");
    }
}
