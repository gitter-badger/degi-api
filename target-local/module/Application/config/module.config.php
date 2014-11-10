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
            'food_certification_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/food_certification[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\FoodCertification'
            				),
            		),
            ),
            'index_slide_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/index_slide[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\IndexSlide'
            				),
            		),
            ),
            'news_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/news[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\NewsMain'
            				),
            		),
            ),
            'contact_us_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/contact_us[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\ContactUs'
            				),
            		),
            ),
            'store_location_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/store_location[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\StoreLocation'
            				),
            		),
            ),
            'bulk_item_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/bulk_item[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\BulkItem'
            				),
            		),
            ),
            'bulk_order_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/bulk_order[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\BulkOrderMain'
            				),
            		),
            ),
            'company_member_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/company_member[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\CompanyMemberPoint'
            				),
            		),
            ),
            'system_variable_f' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/f/system_variable[/:id]',
            				'defaults' => array(
            						'controller' => 'Application\Controller\SystemVariable'
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
            'Application\Controller\PopularItem' => 'Application\Controller\PopularItemController',
            'Application\Controller\NewsMain' => 'Application\Controller\NewsMainController',
            'Application\Controller\IndexSlide' => 'Application\Controller\IndexSlideController',
            'Application\Controller\FoodCertification' => 'Application\Controller\FoodCertificationController',
            'Application\Controller\ContactUs' => 'Application\Controller\ContactUsController',
            'Application\Controller\StoreLocation' => 'Application\Controller\StoreLocationController',
            'Application\Controller\BulkItem' => 'Application\Controller\BulkItemController',
            'Application\Controller\BulkOrderMain' => 'Application\Controller\BulkOrderMainController',
            'Application\Controller\CompanyMemberPoint' => 'Application\Controller\CompanyMemberPointController',
            'Application\Controller\SystemVariable' => 'Application\Controller\SystemVariableController'            		
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
