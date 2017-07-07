<?php
/**
 * Created by PhpStorm.
 * User: fabio
 * Date: 08/05/17
 * Time: 9.02
 */

namespace MetronicTheme\Controller;

interface ElementsControllerInterface
{
    /**
     * @return mixed
     */
    public function mainAction();

    /**
     * restituisce il widget per la costruzione della topBar
     *
     * @return mixed
     */
    public function topAction();

    /**
     * restituisce il widget per la costruzione della sideBar
     * @return mixed
     */
    public function sidebarAction();

    /**
     * restituisce il widget per la costruzione della quickSideBar
     * @return mixed
     */
    public function quickSidebarAction();

    /**
     * restituisce il widget per la costruzione del logo
     * @return mixed
     */
    public function logoAction();
}