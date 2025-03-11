<?php

namespace Webkul\FPC\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Category\Models\Category;
use Webkul\Product\Models\Product;
use Webkul\Checkout\Models\Cart;
use Webkul\Customer\Models\Customer;
use Webkul\Sales\Models\Order;
use Webkul\FPC\Listeners\ReviewUpdateListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'customer.review.update.after' => [
            'Webkul\FPC\Listeners\Review@afterUpdate',
        ],
    ];
}