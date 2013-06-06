<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */




return array(

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Album' => 'Admin\Controller\AlbumController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/]',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'login',
                            'defaults' => array(
                                'action' => 'login'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'logout',
                            'defaults' => array(
                                'action' => 'logout'
                            )
                        )
                    )
                ),
            ),        
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/album/[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller', 
                        'controller' => 'Album',
                        'action'     => 'index',
                    ),
                ),
            ), 

        ),
    ),   
    
    
    'navigation' => array(
        'admin' => array(
            'Home' => array(
                'label' => 'Home',
                'route' => 'admin',
                'pages' => array(
                    array(
                        'label' => 'Login',
                        'route' => 'login',
                        'action' => 'login',
                    ),
                    array(
                        'label' => 'Logout',
                        'route' => 'logout',
                        'action' => 'logout',
                    ),
                )
            ),
            'Albums' => array(
                'label' => 'Albums',
                'route' => 'album',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'album',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'album',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'album',
                        'action' => 'delete',
                    ),
                )
            ),
        ),
    ),
    
    
    'service_manager' => array(
        
        /*
        'Admin\Authentication\Service' => function($sm) {
            $authService = new \Zend\Authentication\AuthenticationService();
            $authService->setStorage(new \Zend\Authentication\Storage\Session('user', 'details'));
            return $authService;
        },*/
        'factories' => array(
            'admin_navigation' => 'Admin\Navigation\Service\AdminNavigationFactory',            
        ),
        'services' => array(
            'Zend\Authentication\AuthenticationService' => new Zend\Authentication\AuthenticationService(),
        )
    ),

    
    
    'view_manager' => array(
        'template_map' => array(
            'admin/layout'           => __DIR__ . '/../view/layout/cms.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),


);


