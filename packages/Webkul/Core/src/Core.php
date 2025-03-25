<?php

namespace Webkul\Core;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Concerns\CurrencyFormatter;
use Webkul\Core\Models\Channel;
use Webkul\Core\Repositories\ChannelRepository;
use Webkul\Core\Repositories\CountryRepository;
use Webkul\Core\Repositories\CountryStateRepository;
use Webkul\Core\Repositories\CurrencyRepository;
use Webkul\Core\Repositories\ExchangeRateRepository;
use Webkul\Core\Repositories\LocaleRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Tax\Repositories\TaxCategoryRepository;
use Webkul\Customer\Contracts\CustomerGroup as CustomerGroupContract;
use Webkul\Customer\Models\CustomerGroup;
use Illuminate\Support\Collection;

class Core
{
    use CurrencyFormatter;

    /**
     * The Bagisto version.
     *
     * @var string
     */
    const BAGISTO_VERSION = '2.2.x-dev';

    /**
     * Current Channel.
     *
     * @var \Webkul\Core\Models\Channel
     */
    protected $currentChannel;

    /**
     * Default Channel.
     *
     * @var \Webkul\Core\Models\Channel
     */
    protected $defaultChannel;

    /**
     * Channel Repository
     *
     * @var \Webkul\Core\Repositories\ChannelRepository
     */
    protected $channelRepository;

    /**
     * Currency.
     *
     * @var \Webkul\Core\Models\Currency
     */
    protected $currentCurrency;

    /**
     * Base Currency.
     *
     * @var \Webkul\Core\Models\Currency
     */
    protected $baseCurrency;

    /**
     * Current Locale.
     *
     * @var \Webkul\Core\Models\Locale
     */
    protected $currentLocale;

    /**
     * Guest Customer Group
     *
     * @var \Webkul\Customer\Models\CustomerGroup
     */
    protected $guestCustomerGroup;

    /**
     * Exchange rates
     *
     * @var array
     */
    protected $exchangeRates = [];

    /**
     * Exchange rates
     *
     * @var array
     */
    protected $taxCategoriesById = [];

    /**
     * Stores singleton instances
     *
     * @var array
     */
    protected $singletonInstances = [];

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(
        ChannelRepository $channelRepository,
        protected CurrencyRepository $currencyRepository,
        protected ExchangeRateRepository $exchangeRateRepository,
        protected CountryRepository $countryRepository,
        protected CountryStateRepository $countryStateRepository,
        protected LocaleRepository $localeRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected TaxCategoryRepository $taxCategoryRepository
    ) {
        $this->channelRepository = $channelRepository;
    }

    /**
     * Get all channels
     * 
     * @return mixed
     */
    public function getAllChannels()
    {
        return $this->channelRepository->all();
    }

    /**
     * Get current channel
     * 
     * @return mixed
     */
    public function getCurrentChannel()
    {
        if ($this->currentChannel) {
            return $this->currentChannel;
        }

        return $this->currentChannel = $this->channelRepository->findByCode(config('app.channel'));
    }

    /**
     * Set current channel
     * 
     * @param mixed $channel
     * @return void
     */
    public function setCurrentChannel($channel)
    {
        $this->currentChannel = $channel;
    }

    /**
     * Get current channel code
     * 
     * @return string
     */
    public function getCurrentChannelCode()
    {
        return $this->getCurrentChannel()->code ?? null;
    }

    /**
     * Get default channel
     * 
     * @return mixed
     */
    public function getDefaultChannel()
    {
        if ($this->defaultChannel) {
            return $this->defaultChannel;
        }

        return $this->defaultChannel = $this->channelRepository->findByCode(config('app.channel'));
    }

    /**
     * Set default channel
     * 
     * @param mixed $channel
     * @return void
     */
    public function setDefaultChannel($channel)
    {
        $this->defaultChannel = $channel;
    }

    /**
     * Get default channel code
     * 
     * @return string
     */
    public function getDefaultChannelCode()
    {
        return $this->getDefaultChannel()->code ?? null;
    }

    /**
     * Get requested channel
     * 
     * @return mixed
     */
    public function getRequestedChannel()
    {
        return $this->channelRepository->findByCode(request()->input('channel'));
    }

    /**
     * Set requested channel
     * 
     * @param mixed $channel
     * @return void
     */
    public function setRequestedChannel($channel)
    {
    }

    /**
     * Get requested channel code
     * 
     * @return string
     */
    public function getRequestedChannelCode()
    {
        return $this->getRequestedChannel()->code ?? null;
    }

    /**
     * Format price
     * 
     * @param float $price
     * @return string
     */
    public function formatPrice($price)
    {
        return number_format($price, 2);
    }

    /**
     * Set current price format
     * 
     * @param string $format
     * @return void
     */
    public function setCurrentPriceFormat($format)
    {
    }



    /**
     * Retrieve all grouped states by country code.
     *
     * @return \Illuminate\Support\Collection
     */
    public function groupedStatesByCountries(): Collection
    {
        $collection = [];

        foreach (DB::table('country_states')->get() as $state) {
            $collection[$state->country_code][] = $state;
        }

        return collect($collection);
    }

    /**
     * Retrieve all grouped states by country code.
     *
     * @return \Illuminate\Support\Collection
     */
    public function findStateByCountryCode($countryCode = null, $stateCode = null): mixed
    {
        $collection = $this->countryStateRepository->findByField(['country_code' => $countryCode, 'code' => $stateCode]);

        if (count($collection)) {
            return $collection->first();
        } else {
            return collect();
        }
    }

    /**
     * Return guest customer group.
     *
     * @return \Webkul\Customer\Contracts\CustomerGroup
     */
    public function getGuestCustomerGroup(): CustomerGroupContract
    {
        if ($this->guestCustomerGroup) {
            return $this->guestCustomerGroup;
        }

        $customerGroup = $this->customerGroupRepository->findOneByField('code', 'guest');
        
        if ($customerGroup instanceof CustomerGroupContract) {
            $this->guestCustomerGroup = $customerGroup;
            return $this->guestCustomerGroup;
        }

        throw new \Exception('CustomerGroup does not implement CustomerGroupContract');
    }

    /**
     * Create singleton object through single facade.
     *
     * @param  string  $className
     * @return object
     */
    public function getTaxCategoryById($id): ?object
    {
        if (empty($id)) {
            return null;
        }

        if (array_key_exists($id, $this->taxCategoriesById)) {
            return $this->taxCategoriesById[$id];
        }

        return $this->taxCategoriesById[$id] = $this->taxCategoryRepository->find($id);
    }

    /**
     * Format base price
     * 
     * @param float $price
     * @return string
     */
    public function formatBasePrice($price)
    {
        return number_format($price, 2);
    }
}