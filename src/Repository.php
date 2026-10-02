<?php

namespace NetOS\Repository;

use Illuminate\Contracts\Foundation\Application;

class Repository
{
    public function __construct(protected Application $app)
    {
    }
}
