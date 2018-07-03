<?php
return [
    'controllers' => [
        'invokables' => [

        ],
        'factories' => [
            \Blog\Controller\EntryController::class => \Blog\Factory\EntryController::class,
            \Blog\Controller\BlogController::class => \Blog\Factory\BlogController::class,
            \Blog\Controller\UserController::class => \Blog\Factory\UserController::class,
        ],
    ],

    'service_manager' => [
        'invokables' => [
            Blog\Listener\LoginStatus::class => Blog\Listener\LoginStatus::class,
        ],
        'factories' => [
            \Blog\Service\BlogService::class => \Blog\Factory\BlogService::class,
        ]
    ],

    'view_helpers' => [
        'invokables' => [
            'bootstrapHelper' => \Blog\View\Helper\Bootstrap::class,
        ]
    ],

    /*
    'constraints' => [
        #'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        #'id'     => '[0-9]+',
    ],
    */
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/blog',
                    'defaults' => [
                        'controller' => \Blog\Controller\BlogController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '[/page/:page]',
                            'constraints' => [
                                'page' => '\d',

                            ],
                        ],
                    ],
                    'tag' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/by-tag[/:tag][/page/:page]',
                            'constraints' => [
                                'page' => '\d',
                                'tag' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                    'userEntries' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/user-entries[/:user][/page/:page]',
                            'defaults' => [
                                'action' => 'userEntries',
                            ],
                            'constraints' => [
                                'page' => '\d',
                                'user' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                        ],
                    ],
                ],
            ],
            'login' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action' => 'login',
                    ],
                ],
            ],
            'register' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/register[/:error]',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action' => 'register',
                    ],
                ],
            ],
            'registration' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/registration',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                        'action' => 'registration',
                    ],
                ],
            ],
            'logout' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/logout',
                    'defaults' => [
                        'controller' => \Blog\Controller\UserController::class,
                        'action' => 'logout',
                    ],
                ],
            ],
            'processLogin' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/login-post',
                    'defaults' => [
                        'controller' => \Blog\Controller\UserController::class,
                        'action' => 'processLogin',
                    ],
                ],
            ],
            'editEntry' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/edit-entry-post[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action' => 'editEntry',
                    ],
                ],
            ],
            'addComment' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/details-post[/:id]',
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action' => 'addComment',
                    ],
                ],
            ],
            'entry' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/entry',
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                        'action' => 'add',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'add' => [
                        'type' => \Zend\Mvc\Router\Http\Segment::class,
                        'options' => [
                            'route' => '/add',
                            'defaults' => [
                                'controller' => \Blog\Controller\EntryController::class,
                                'action' => 'add',
                            ],
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'get' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'get',
                                    'defaults' => [
                                        'controller' => \Blog\Controller\EntryController::class,
                                        'action' => 'add',
                                    ],
                                ],
                            ],
                            'post' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'post',
                                    'defaults' => [
                                        'controller' => \Blog\Controller\EntryController::class,
                                        'action' => 'createEntry',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/edit[/:id]',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'id' => '[0-9]+',
                            ]
                        ],
                    ],
                    'delete' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/delete[/:id]',
                            'defaults' => [
                                'action' => 'delete',
                            ],
                            'constraints' => [
                                'id' => '[0-9]+',
                            ]
                        ],
                    ],
                    'details' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/details[/:id]',
                            'defaults' => [
                                'action' => 'details',
                            ],
                            'constraints' => [
                                'id' => '[0-9]+',
                            ]
                        ],
                    ],
                ],
            ],
        ],
    ],

    'listeners' => [
        \Blog\Listener\LoginStatus::class,
    ],
    'view_manager' => [
        'template_path_stack' => [
            'blog' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'BlogDriver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Blog/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Blog\Entity' => 'BlogDriver'
                ]
            ]
        ]
    ],
];