<?php

namespace SilverStripe\UserGuide\Model;

use SilverStripe\ORM\DataObject;

class UserGuide extends DataObject
{
    private static $table_name = "UserGuide";

    private static $db = [
        'Title' => 'Varchar',
        'PreNotes' => 'HTMLText',
        'Content' => 'HTMLText',
        'PostNotes' => 'HTMLText',
        'MarkdownPath' => 'Varchar',
    ];
}
