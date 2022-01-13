<?php

use SilverStripe\Admin\CMSMenu;
use SilverStripe\UserGuide\Controller\CMSUserGuideController;

CMSMenu::remove_menu_class(CMSUserGuideController::class);
