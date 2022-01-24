<?php

namespace SilverStripe\UserGuide\Extension;

use SilverStripe\Core\ClassInfo;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\UserGuide\Model\UserGuide;

class UserGuideExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $ownerClass = get_class($this->getOwner());
        $userguide = UserGuide::get()->filter('DerivedClass', $ownerClass)->first();
        if ($userguide && $userguide->exists()) {
            $fields->addFieldsToTab(
                'Root.UserGuide',
                [
                    HTMLEditorField::create(
                        'UserGuidePreNotes',
                        'User Guide Pre-Content',
                        $userguide->PreNotes
                    )->setRows(10),
                    HTMLEditorField::create(
                        'UserGuidePostContent',
                        'User Guide Post-Content',
                        $userguide->PostNotes
                    )->setRows(10),
                ]
            );
        }
        return $fields;
    }
}
