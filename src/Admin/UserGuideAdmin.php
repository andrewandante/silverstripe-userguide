<?php

namespace SilverStripe\UserGuide\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\UserGuide\Model\UserGuide;

class UserGuideAdmin extends ModelAdmin
{
    private static $managed_models = [
        UserGuide::class,
    ];

    private static $url_segment = 'userguide';

    private static $menu_icon_class = 'font-icon-block-content';

    private static $menu_title = 'User Guides';

    protected function getGridFieldConfig(): GridFieldConfig
    {
        $config =  parent::getGridFieldConfig();
        $config->removeComponentsByType(GridFieldAddNewButton::class);

        return $config;
    }
}
