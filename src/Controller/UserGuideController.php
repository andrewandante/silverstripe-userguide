<?php

namespace SilverStripe\UserGuide\Controller;

use SilverStripe\Dev\Debug;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;

class UserGuideController extends Controller
{

    private static $url_handlers = [
        'filePath' => 'index',
    ];

    public function index(HTTPRequest $request) {
        $filePath = $request->getVar('filePath');
    }

}
