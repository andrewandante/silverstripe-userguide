<?php

namespace SilverStripe\UserGuide\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\ORM\DataExtension;
use SilverStripe\UserGuide\Model\UserGuide;

class UserGuideExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $ownerClass = get_class($this->getOwner());
        $userguides = UserGuide::get()->filter('DerivedClass', $ownerClass);
        if ($userguides->Count() > 0) {
            $fields->addFieldsToTab(
                'Root.UserGuide',
                [
                    GridField::create('Userguides', 'User guides', $userguides, GridFieldConfig_RecordViewer::create())
                ]
            );
        }
        return $fields;
    }

}
