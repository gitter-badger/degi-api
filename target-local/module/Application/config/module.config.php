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
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
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
            'auth_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/auth[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\Auth'
            				),
            		),
            ),
            'member_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/member[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\Member'
            				),
            		),
            ),
            'item_category_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/item_category[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\ItemCategory'
            				),
            		),
            ),
            'item_list_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/item_list[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\ItemList'
            				),
            		),
            ),
            'carousel_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/carousel[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\Carousel'
            				),
            		),
            ),
            'item_info_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/item_info[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\ItemInfo'
            				),
            		),
            ),
            'popular_item_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/popular_item[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\PopularItem'
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
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Auth' => 'Application\Controller\AuthController',
            'Application\Controller\Member' => 'Application\Controller\MemberController',
            'Application\Controller\ItemCategory' => 'Application\Controller\ItemCategoryController',
            'Application\Controller\ItemList' => 'Application\Controller\ItemListController',
            'Application\Controller\Carousel' => 'Application\Controller\CarouselController',
            'Application\Controller\ItemInfo' => 'Application\Controller\ItemInfoController',
            'Application\Controller\PopularItem' => 'Application\Controller\PopularItemController'
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
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
