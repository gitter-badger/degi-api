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
            'auth_b' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/auth[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Auth'
            				),
            		),
            ),
            'adminer_b' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/admin[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Adminer'
            				),
            		),
            ),
            'member_b' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/member[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Member'
            				),
            		),
            ),
            'order_b' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/order[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Order'
            				),
            		),
            ),
            'item_category_b' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/item_category[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\ItemCategory'
            				),
            		),
            ),
            'item_category_relate' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/item_category_relate[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\ItemCategoryRelate'
            				),
            		),
            ),
            'item_main' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/item_main[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\ItemMain'
            				),
            		),
            ),
            'item_flavor' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/item_flavor[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\ItemFlavor'
            				),
            		),
            ),
            'news' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/news[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\News'
            				),
            		),
            ),
            'popular_item' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/popular_item[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\PopularItem'
            				),
            		),
            ),
            'food' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/food[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\Food'
            				),
            		),
            ),
            'system_variable' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/b/system_variable[/:id]',
            				'defaults' => array(
            						'controller' => 'Administrator\Controller\SystemVariable'
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
            'Administrator\Controller\Auth' => 'Administrator\Controller\AuthController',
            'Administrator\Controller\Adminer' => 'Administrator\Controller\AdminerController',
            'Administrator\Controller\Member' => 'Administrator\Controller\MemberController',   
            'Administrator\Controller\Order' => 'Administrator\Controller\OrderController',      
            'Administrator\Controller\ItemCategory' => 'Administrator\Controller\ItemCategoryController',
            'Administrator\Controller\ItemCategoryRelate' => 'Administrator\Controller\ItemCategoryRelateController',
            'Administrator\Controller\ItemMain' => 'Administrator\Controller\ItemMainController',
            'Administrator\Controller\ItemFlavor' => 'Administrator\Controller\ItemFlavorController',
            'Administrator\Controller\News' => 'Administrator\Controller\NewsController',
            'Administrator\Controller\PopularItem' => 'Administrator\Controller\PopularItemController',
            'Administrator\Controller\Food' => 'Administrator\Controller\FoodController',
            'Administrator\Controller\SystemVariable' => 'Administrator\Controller\SystemVariableController'
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
