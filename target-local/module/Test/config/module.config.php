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
           
            'test' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/test',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Test\Controller',
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
            'auth_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/auth[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\Auth'
            				),
            		),
            ),
            'alarm_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/alarm[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\Alarm'
            				),
            		),
            ),
            'adminer_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/admin[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\Adminer'
            				),
            		),
            ),
            'member_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/member[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\Member'
            				),
            		),
            ),
            'gps_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/gps[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\GPS'
            				),
            		),
            ),
            'indoor_location_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/indoor_location[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\IndoorLocation'
            				),
            		),
            ),
            'indoor_monitor_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/indoor_monitor[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\IndoorMonitor'
            				),
            		),
            ),
            'system_variable_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/system_variable[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\SystemVariable'
            				),
            		),
            ),
            'work_rest_t' => array(
            		'type' => 'Segment',
            		'options' => array(
            				'route'    => '/t/work_rest[/:id]',
            				'defaults' => array(
            						'controller' => 'Test\Controller\WorkRest'
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
            'Test\Controller\Index' => 'Test\Controller\IndexController',
            'Test\Controller\GPS' => 'Test\Controller\GPSController',
            'Test\Controller\IndoorLocation' => 'Test\Controller\IndoorLocationController',
            'Test\Controller\IndoorMonitor' => 'Test\Controller\IndoorMonitorController',
            'Test\Controller\Auth' => 'Test\Controller\AuthController',
            'Test\Controller\Alarm' => 'Test\Controller\AlarmController',
            'Test\Controller\Adminer' => 'Test\Controller\AdminerController',
            'Test\Controller\Member' => 'Test\Controller\MemberController',  
            'Test\Controller\SystemVariable' => 'Test\Controller\SystemVariableController',
            'Test\Controller\WorkRest' => 'Test\Controller\WorkRestController'
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
            'test/index/index' => __DIR__ . '/../view/test/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
