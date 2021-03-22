<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class AbstractAdmin extends BaseAbstractAdmin
{
    protected $datagridValues = [
        '_per_page' => 10,
    ];
    protected $maxPerPage = 10;
    protected $perPageOptions = [10, 16, 32, 64, 128, 192];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('list');
    }
}