<?php
return array(
    'controllers' => array(
        'invokables' => array(

        ),
        'factories' => array(
            //ToDo Factories anpassen Klassen referenz
            \Blog\Controller\LoginController::class => \Blog\Factory\LoginController::class,
            \Blog\Controller\EntryController::class => \Blog\Factory\EntryController::class,
            \Blog\Controller\BlogController::class => \Blog\Factory\BlogController::class,
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            Blog\Listener\LoginStatus::class => Blog\Listener\LoginStatus::class,
        ),
        'factories' => [
           \Blog\Service\BlogService::class => \Blog\Factory\BlogService::class,
        ]
    ),

    'view_helpers' => array(
        'invokables' => array(
            'bootstrapHelper' => \Blog\View\Helper\Bootstrap::class,
        )
    ),

    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => \Blog\Controller\BlogController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
            'login' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller' => Blog\Controller\LoginController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller' => \Blog\Controller\LoginController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'loginPost' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/post',
                    'defaults' => [
                        'controller' => \Blog\Controller\LoginController::class,
                        'action'     => 'loginPost',
                    ],
                ],
            ],
            'entry' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/entry[/:action][/:id]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action'     => 'add',
                    ],
                ],
            ],
        ),
    ),

    'listeners' => [
        \Blog\Listener\LoginStatus::class,
    ],
    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'BlogDriver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Blog/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Blog\Entity' => 'BlogDriver'
                )
            )
        )
    ),
);