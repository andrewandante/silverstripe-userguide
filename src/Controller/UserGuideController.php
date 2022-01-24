<?php

namespace SilverStripe\UserGuide\Controller;

use SilverStripe\Dev\Debug;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;

class UserGuideController extends Controller
{

    private static $url_handlers = [
        'filePath' => 'index',
        'streamInImage' => 'index',
    ];

    public function index(HTTPRequest $request) {
        if (!Security::getCurrentUser()) {
            return Security::permissionFailure();
        }



        $filePath = $request->getVar('filePath');
        $streamInImage = $request->getVar('streamInImage');
        if (file_exists(BASE_PATH . $streamInImage)) {
            return file_get_contents(BASE_PATH . $streamInImage);
        }
    }

}
