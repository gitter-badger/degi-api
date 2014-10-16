<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
           
            'administrator' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/administrator',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Administrator\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'auth' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/auth[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Auth'
            				),
            		),
            ),
            'adminer' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/admin[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Adminer'
            				),
            		),
            ),
            'item_category' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/item_category[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\ItemCategory'
            				),
            		),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Administrator\Controller\Index' => 'Administrator\Controller\IndexController',
            'Administrator\Controller\Adminer' => 'Administrator\Controller\AdminerController',
            'Administrator\Controller\ItemCategory' => 'Administrator\Controller\ItemCategoryController',
            'Administrator\Controller\Auth' => 'Administrator\Controller\AuthController'
         ),
    ),
    'view_manager' => array(
        'strategies' => array('ViewJsonStrategy'),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'administrator/index/index' => __DIR__ . '/../view/administrator/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
