<?php

namespace MetronicTheme;

use MetronicTheme\Controller\ElementsController;
use Zend\ServiceManager\Factory\InvokableFactory;

$theme = 'metronic-theme/admin_1';

return [
    /**
     * metronic-theme se  una rotta con chiave assets
     */
    'router' => [
        'routes' => [
            'assets-metronic' => [
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route' => '/assets/metronic',
                ],
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            ElementsController::class => InvokableFactory::class,
        ],
    ],
    'metronic-theme' => [
        /**
         * controller che implementa MetronicTheme\ElementsControllerInterface
         */
        'elements_controller' => ElementsController::class,
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . "/../view/$theme/layout/layout.phtml",
            'layout/flat_layout' => __DIR__ . "/../view/$theme/layout/flat_layout.phtml",
            'layout/login' => __DIR__ . "/../view/$theme/layout/login.phtml",
            'error/404' => __DIR__ . "/../view/$theme/error/404.phtml",
            'error/index' => __DIR__ . "/../view/$theme/error/index.phtml",
            'partials/sidebar_menu' => __DIR__ . "/../view/$theme/partials/sidebar.phtml",
            'partials/breadcrumbs' => __DIR__ . "/../view/$theme/partials/breadcrumbs.phtml",
        ],
        'template_path_stack' => [
            'standard' => __DIR__ . '/../view/',
//            'Theme' => __DIR__ . '/../view/' . $theme,
        ],
    ],
    'view_helper' => [
    ],

    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public/metronic-theme',
            ],
        ],
    ],
    'navigation' => [
        'default' => [],
        'breadcrumbs' => []
    ]
];
