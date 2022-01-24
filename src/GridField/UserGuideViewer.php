<?php

namespace SilverStripe\UserGuide\GridField;

use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldViewButton;

/**
 * Allows viewing readonly details of individual records.
 */
class UserGuideViewer extends GridFieldConfig_Base
{
    public function __construct($itemsPerPage = null)
    {
        parent::__construct($itemsPerPage);

        $this->addComponent(new UserGuideViewButton());
        $this->removeComponentsByType(GridFieldFilterHeader::class);

        $this->extend('updateConfig');
    }
}
