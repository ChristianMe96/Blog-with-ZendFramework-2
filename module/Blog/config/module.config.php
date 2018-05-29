<?php
return array(
    'controllers' => array(
        'invokables' => array(

        ),
        'factories' => array(
            //ToDo Factories anlegen
            'Blog\Controller\Blog'=> \Blog\Factory\BlogController::class
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            Blog\Listener\LoginStatus::class => Blog\Listener\LoginStatus::class,
        ),
    ),

    'router' => array(
        'routes' => array(
            'blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
            ),
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