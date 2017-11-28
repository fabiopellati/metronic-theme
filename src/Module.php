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
            $elementsControllerClass = $metronic_theme_config['elements_controller'];
            $controller = $e->getTarget();
            $isViewModel = get_class($e->getViewModel()) === ViewModel::class;
            if ($isViewModel && get_class($controller) != $elementsControllerClass) {
                $logo = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'logo']);
                $controller->layout()->addChild($logo, 'logo');
                $side_bar = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'main']);
                $controller->layout()->addChild($side_bar, 'main');
                $side_bar = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'sidebar']);
                $controller->layout()->addChild($side_bar, 'sideBar');
                $top_menu = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'top']);
                $controller->layout()->addChild($top_menu, 'topMenu');
                $quickSidebar = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'quickSidebar']);
                $controller->layout()->addChild($quickSidebar, 'quickSidebar');
                $footer = $controller->forward()->dispatch($elementsControllerClass, ['action' => 'footer']);
                $controller->layout()->addChild($footer, 'footer');
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
                $assets = $renderer->plugin('Url')->__invoke('assets-metronic');
//                $base_path = $renderer->plugin('BasePath')->__invoke($assets);
                $script = <<<JS
                var App =  App || {};
                App.assets = "$assets";
                App.setAssetsPath( App.assets+ "/assets/");

JS;
                $renderer->plugin('HeadScript')->appendScript($script, 'text/javascript');
            }
        });
    }
}
