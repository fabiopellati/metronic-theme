<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MetronicTheme\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NavigationController extends AbstractActionController
{
    public function mainAction()
    {
        return new ViewModel();
    }

    public function topAction()
    {

        return new ViewModel();
    }

    public function sidebarAction()
    {
        return new ViewModel();
    }

    public function quickSidebarAction()
    {
        return new ViewModel();
    }

}
