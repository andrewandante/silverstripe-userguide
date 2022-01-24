<?php

namespace SilverStripe\UserGuide\Controller;

use SilverStripe\CMS\Controllers\CMSMain;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\HTTPResponse_Exception;
use SilverStripe\UserGuide\Model\UserGuide;
use Page;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordViewer;
use SilverStripe\Forms\GridField\LoadUserGuide;
use SilverStripe\UserGuide\GridField\GridFieldLoadUserGuide;
use SilverStripe\UserGuide\GridField\UserGuideViewer;

class CMSUserGuideController extends CMSMain
{
    private static string $url_segment = 'pages/guide';

    private static string $url_rule = '/$Action/$ID/$OtherID';

    private static int $url_priority = 42;

    private static string $required_permission_codes = 'CMS_ACCESS_CMSMain';

    private static $allowed_actions = [
        'markdown',
        'show',
    ];


    public function getEditForm($id = null, $fields = null)
    {
        $id = $this->currentPageID();
        $page = Page::get_by_id($id);
        $userguides = UserGuide::get()->filter('DerivedClass', $page->ClassName);
        $fieldList = FieldList::create(
            GridField::create(
                'Userguides',
                'User guides',
                $userguides,
                UserGuideViewer::create()
            )
        );
        return parent::getEditForm($id, $fieldList);
    }

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
        // $response->addHeader('X-Reload', true);
        $response->setBody(json_encode([
            'ID' => $pageID,
            'Content' => $this->getUserGuideContent(),
        ]));

        return $response;
    }

    public function show($request)
    {
        $response = parent::show($request);
        if ($request->getVar('ugid')) {
            $response->addHeader('X-Reload', true);
            $response->addHeader('X-ControllerURL', $request->getURL(true));
        }
        return $response;
    }
}
