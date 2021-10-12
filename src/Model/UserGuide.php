<?php

namespace SilverStripe\UserGuide\Model;

use SilverStripe\ORM\DataObject;

class UserGuide extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'PreNotes' => 'HTMLText',
        'Content' => 'HTMLText',
        'PostNotes' => 'HTMLText',
    ];
}
