<?php

namespace SilverStripe\UserGuide\Model;

use SilverStripe\ORM\DataObject;

class UserGuide extends DataObject
{
    private static $table_name = 'UserGuide';

    private static $db = [
        'Type' => 'Varchar',
        'Title' => 'Varchar',
        'PreNotes' => 'HTMLText',
        'Content' => 'HTMLText',
        'PostNotes' => 'HTMLText',
        'MarkdownPath' => 'Varchar',
        'DerivedClass' => 'Varchar',
    ];

    private static $summary_fields = [
        'Type' => 'File type',
        'Title' => 'File Name',
        'DerivedClass' => 'Class',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'PreNotes',
            'PostNotes'
        ]);

        $fields->makeFieldReadonly([
            'Title',
            'Content',
            'MarkdownPath',
            'DerivedClass',
        ]);

        $fields->dataFieldByName('Content')->addExtraClass('img-max-width table-borders');

        return $fields;
    }
}
