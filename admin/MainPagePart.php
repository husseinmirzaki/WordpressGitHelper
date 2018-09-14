<?php
/**
 * Created by PhpStorm.
 * User: Hussein Mirzaki
 * Date: 9/14/2018
 * Time: 6:50 PM
 */

trait MainPagePart
{


    public function setUpMainPageMenu()
    {
        add_menu_page('GitHelper', 'GitHelper', 'manage_options', $this->menu_slugs[0], [$this, 'gitHelperMainPage']);
    }
}