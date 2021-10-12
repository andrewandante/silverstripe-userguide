<?php

namespace SilverStripe\UserGuide\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class UserGuideExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            'Root.UserGuide',
            [
                HTMLEditorField::create(
                    'PreContent',
                    'Pre-Content',
                    $this->getPreContent()
                )->performReadonlyTransformation(),
                HTMLEditorField::create(
                    'Content',
                    'Content',
                    $this->getContent()
                )->performReadonlyTransformation(),
                HTMLEditorField::create(
                    'PostContent',
                    'Post-Content',
                    $this->getPostContent()
                )->performReadonlyTransformation(),
            ]
        );

        return $fields;
    }

    public function getPreContent()
    {
        return '<h4>This is just a pre content</h4>';
    }

    public function getContent()
    {
        return '<h2>This is just a main content</h2>';
    }

    public function getPostContent()
    {

        return '<strong>This is just a post content</strong>';
    }
}
