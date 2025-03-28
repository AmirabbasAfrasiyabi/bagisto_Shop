<?php

namespace Webkul\Core\Repositories;

use Webkul\Core\Eloquent\Repository;
use Webkul\Core\Models\Channel;

class ChannelRepository extends Repository
{
 
    public function model()
    {
        return Channel::class;
    }

    /**
     *
     * @param string $code
     * @return Channel|null
     */
    public function findByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }
}
