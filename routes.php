<?php

use Aura\Router\Map;

// Admin routes for backend
return function(Map $router)
{
    $generator = function($controller) {
        return [
            'method' => ['GET', 'POST'],
            'params' => [
                'id' => '(\d+)',
            ],
            'values' => [
                'controller' => $controller,
            ],
            'routes' => [
                'browse' => '/?',
                'create' => '/new',
                'read' => '/{:id}',
                'update' => '/{:id}/edit',
                'delete' => '/{:id}/delete',
            ]
        ];
    };

    $router->add('dashboard', '/admin/dashboard', [
        'values' => [
            'controller' => 'admin',
            'action'     => 'index',
        ]
    ]);

    $router->add('save', '/admin/save', [
        'method' => ['POST'],
        'values' => [
            'controller' => 'admin',
            'action' => 'save',
        ]
    ]);

    $router->attach('/admin/blog', $generator('blog'));
    $router->attach('/admin/users', $generator('users'));

    $router->add(null, '/admin/{:controller}/{:action}/{:id:(\d+)}');
};