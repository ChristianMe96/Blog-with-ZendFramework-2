<?php
return array(
    'controllers' => array(
        'invokables' => array(

        ),
        'factories' => array(
            //ToDo Factories anpassen Klassen referenz
            \Blog\Controller\EntryController::class => \Blog\Factory\EntryController::class,
            \Blog\Controller\BlogController::class => \Blog\Factory\BlogController::class,
            \Blog\Controller\UserController::class => \Blog\Factory\UserController::class,
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
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/[page/:page]',
                    'defaults' => array(
                        'controller' => \Blog\Controller\BlogController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
            'userEntries' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/userEntries[/:user]/[page/:page]',
                    'defaults' => array(
                        'controller' => \Blog\Controller\BlogController::class,
                        'action'     => 'userEntries',
                    ),
                ),
            ),
            'login' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/Login',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'register' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/Register[/:error]',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action'     => 'register',
                    ],
                ],
            ],
            'registration' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/Registration',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action'     => 'registration',
                    ],
                ],
            ],
            'logout' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/Logout',
                    'defaults' => [
                        'controller' => \Blog\Controller\UserController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],
            'processLogin' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/loginPost',
                    'defaults' => [
                        'controller' => \Blog\Controller\UserController::class,
                        'action'     => 'processLogin',
                    ],
                ],
            ],
            'createEntry' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/entryPost',
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action'     => 'createEntry',
                    ],
                ],
            ],
            'editEntry' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/editEntryPost[/:id]',
                    'constraints' => [
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action'     => 'editEntry',
                    ],
                ],
            ],
            'addComment' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/detailsPost[/:id]',
                    'constraints' => [
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action'     => 'addComment',
                    ],
                ],
            ],
            'entry' => [
                'type'    => 'Segment',
                'options' => [
                    'route'    => '/Entry[/:action][/:id]',
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