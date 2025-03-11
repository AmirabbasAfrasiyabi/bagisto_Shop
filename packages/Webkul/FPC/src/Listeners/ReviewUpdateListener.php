<?php

namespace Webkul\FPC\Listeners;

use Webkul\Product\Contracts\Review;
use Spatie\ResponseCache\Facades\ResponseCache;

class ReviewUpdateListener
{
    /**
     * بعد از بروزرسانی یک نظر، کش مرتبط را پاک می‌کند.
     *
     * @param  \Webkul\Product\Contracts\Review  $review
     * @return void
     **/
    public function afterUpdate($review)
    {
        ResponseCache::forget('/' . $review->product->url_key);
    }
}
