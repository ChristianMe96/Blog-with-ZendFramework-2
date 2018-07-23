<?php
return [
    'controllers' => [
        'invokables' => [
            \Blog\Controller\MailController::class => \Blog\Controller\MailController::class
        ],
        'factories' => [
            \Blog\Controller\StatisticController::class => \Blog\Factory\StatisticController::class,
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
            \Blog\Listener\VisitorCounter::class => \Blog\Factory\VisitorCounter::class
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
            'redirectHome' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => \Blog\Controller\BlogController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'login' => [
                'type' => \Zend\Mvc\Router\Http\Literal::class,
                'options' => [
                    'route' => '/login',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'get' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'action' => 'login'
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'action' => 'processLogin'
                            ],
                        ],
                    ],
                ],
            ],
            'contact' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/contact',
                    'defaults' => [
                        'controller' => \Blog\Controller\MailController::class,
                    ],
                ],
                'may-terminate' => false,
                'child_routes' => [
                    'get' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'action' => 'mailForm',
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'action' => 'sendMail',
                            ],
                        ],
                    ],
                ],
            ],
            'home' => [
                'type' => 'literal',
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

            'register' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/register',
                    'defaults' => [
                        'controller' => Blog\Controller\UserController::class,
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'get' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'get',
                            'defaults' => [
                                'action' => 'register',
                            ],
                        ],
                    ],
                    'post' => [
                        'type' => \Zend\Mvc\Router\Http\Method::class,
                        'options' => [
                            'verb' => 'post',
                            'defaults' => [
                                'action' => 'registration',
                            ],
                        ],
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
            'visitorChart' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/visitor-chart',
                    'defaults' => [
                        'controller' => \Blog\Controller\StatisticController::class,
                        'action' => 'visitorChart',
                    ],
                ],
            ],

            'entry' => [
                'type' => 'Literal',
                'options' => [
                    'route' => '/entry',
                    'defaults' => [
                        'controller' => \Blog\Controller\EntryController::class,
                    ],
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'add' => [
                        'type' => \Zend\Mvc\Router\Http\Literal::class,
                        'options' => [
                            'route' => '/add',
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'get' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'get',
                                    'defaults' => [
                                        'action' => 'add',
                                    ],
                                ],
                            ],
                            'post' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'post',
                                    'defaults' => [
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
                            'constraints' => [
                                'id' => '[0-9]+',
                            ]
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'get' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'get',
                                    'defaults' => [
                                        'action' => 'edit',
                                    ],
                                ],
                            ],
                            'post' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'post',
                                    'defaults' => [
                                        'action' => 'editEntry',
                                    ],
                                ],
                            ],
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
                            'constraints' => [
                                'id' => '[0-9]+',
                            ]
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'get' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'get',
                                    'defaults' => [
                                        'action' => 'details',
                                    ],
                                ],
                            ],
                            'post' => [
                                'type' => \Zend\Mvc\Router\Http\Method::class,
                                'options' => [
                                    'verb' => 'post',
                                    'defaults' => [
                                        'action' => 'addComment',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'listeners' => [
        \Blog\Listener\LoginStatus::class,
        \Blog\Listener\VisitorCounter::class
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