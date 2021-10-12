<?php

namespace SilverStripe\UserGuide\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\View\ViewableData;

class UserGuide extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'PreNotes' => 'HTMLText',
        'Content' => 'HTMLText',
        'PostNotes' => 'HTMLText',
    ];

    private static $many_many = [
        'Guides' => ViewableData::class
    ];
}
