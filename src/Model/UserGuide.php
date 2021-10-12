<?php

namespace SilverStripe\UserGuide\Model;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;

class UserGuide extends DataObject
{
    private static $table_name = 'UserGuide';

    private static $db = [
        'Title' => 'Varchar',
        'PreNotes' => 'HTMLText',
        'Content' => 'HTMLText',
        'PostNotes' => 'HTMLText',
        'MarkdownPath' => 'Varchar',
        'DerivedClass' => 'Varchar',
    ];

    private static $summary_fields = [
        'Title' => 'File Name',
        'DerivedClass' => 'Class',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->makeFieldReadonly([
            'Title',
            'Content',
            'MarkdownPath',
            'DerivedClass',
        ]);

        return $fields;
    }
}
