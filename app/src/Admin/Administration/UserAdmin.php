<?php

declare(strict_types=1);


namespace App\Admin\Administration;

use App\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'admin_app_user';
    protected $baseRoutePattern = '/users';

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('disable', $this->getRouterIdParameter() . '/disable');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('_action', null, [
                'actions' => [
                    'disable' => [
                        'template' => 'admin/list__action_disable.html.twig',
                    ],
                ],
            ]);
    }


}