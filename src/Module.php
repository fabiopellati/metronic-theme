<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MetronicTheme;

use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\ViewEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }


    public function onBootstrap(MvcEvent $e)
    {

        $app = $e->getApplication();
        $em = $app->getEventManager();
        /**
         * aggiunta widgets componenti di layout
         */
        $em->attach(MvcEvent::EVENT_DISPATCH, function (MvcEvent $e) {
            $app = $e->getApplication();
            $config = $app->getServiceManager()->get('config');
            $metronic_theme_config = $config['metronic-theme'];
            $navigationControllerClass = $metronic_theme_config['navigation_controller'];
            $controller = $e->getTarget();
            $isViewModel = get_class($e->getViewModel()) === ViewModel::class;
            if ($isViewModel && get_class($controller) != $navigationControllerClass) {
                $side_bar = $controller->forward()->dispatch($navigationControllerClass, ['action' => 'main']);
                $controller->layout()->addChild($side_bar, 'main');
                $side_bar = $controller->forward()->dispatch($navigationControllerClass, ['action' => 'sidebar']);
                $controller->layout()->addChild($side_bar, 'side_bar');
                $top_menu = $controller->forward()->dispatch($navigationControllerClass, ['action' => 'top']);
                $controller->layout()->addChild($top_menu, 'top_menu');
                $top_menu = $controller->forward()->dispatch($navigationControllerClass, ['action' => 'quickSidebar']);
                $controller->layout()->addChild($top_menu, 'quick_sidebar');
            }
        });

        /**
         * aggiunta javascript di inizializzazione
         */
        $sharedEvents = $em->getSharedManager();
        $sharedEvents->attach('Zend\View\View', ViewEvent::EVENT_RENDERER_POST, function (ViewEvent $viewEvent) {
            $renderer = $viewEvent->getRenderer();
            $options = $viewEvent->getModel()->getOptions();
            $captured_to = $viewEvent->getModel()->captureTo();
            if ($renderer instanceof PhpRenderer && !isset($options['has_parent'])
                && $captured_to === 'content'
            ) {
                $assets = $renderer->plugin('Url')->__invoke('assets');
                $base_path = $renderer->plugin('BasePath')->__invoke('assets');
                $script = <<<JS
                if(typeof App == 'undefined'){
                    var App={};
                }
                App.assets = "$assets";
                App.baseUrl = "$base_path";
                App.setAssetsPath( App.assets+ "metronic/theme/assets/");

JS;
                $renderer->plugin('HeadScript')->appendScript($script, 'text/javascript');
            }
        });
    }
}
