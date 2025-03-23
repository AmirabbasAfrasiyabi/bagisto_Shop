<?php

namespace Webkul\Blog\Repositories;

use Webkul\Core\Eloquent\Repository;

class PostRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webkul\Blog\Contracts\Post';
    }
}