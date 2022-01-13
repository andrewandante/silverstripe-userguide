<?php

namespace SilverStripe\UserGuide\Controller;

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\CMS\Controllers\CMSMain;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\UserGuide\Model\UserGuide;
use Page;

class CMSUserGuideController extends CMSMain
{

    private static string $url_segment = 'pages/guide';

    private static string $url_rule = '/$Action/$ID/$OtherID';

    private static int $url_priority = 42;

    private static string $required_permission_codes = 'CMS_ACCESS_CMSMain';

    private static $allowed_actions = [
        'markdown',
    ];

    public function getTabIdentifier(): string
    {
        return 'guide';
    }

    /**
     * @see LeftAndMain::show()
     * @return HTTPResponse
     * @throws HTTPResponse_Exception
     */
    public function markdown(HTTPRequest $request)
    {
        if ($request->param('ID')) {
            $this->setCurrentPageID($request->param('ID'));
        }

        $pageID = $this->currentPageID();
        $response = $this->getResponse();
        $response->addHeader('Content-Type', 'application/json');
        $response->setBody(json_encode([
            'ID' => $pageID,
            'Content' => $this->getUserGuideContent(),
        ]));

        return $response;
    }

}
