<?php

namespace SilverStripe\UserGuide\Extension;

use SilverStripe\Control\Controller;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\UserGuide\Model\UserGuide;
use SilverStripe\UserGuide\Controller\CMSUserGuideController;
use Page;

class CMSMainExtension extends Extension
{

    public function LinkPageUserGuide()
    {
        $owner = $this->getOwner();
        if ($id = $owner->currentPageID()) {
            return $owner->LinkWithSearch(
                Controller::join_links(CMSUserGuideController::singleton()->Link('show'), $id)
            );
        } else {
            return null;
        }
    }

    public function IsUserGuideController()
    {
        return get_class($this->getOwner()) === CMSUserGuideController::class;
    }

    public function ShowUserGuide()
    {
        return HTMLEditorField::create('UserGuideContent', 'User Guide Content', $this->getUserGuideContent())
            ->performReadonlyTransformation();
    }

    public function getUserGuideContent()
    {
        $pageID = $this->getOwner()->currentPageID();

        if (!$pageID) {
            return null;
        }

        $page = Page::get()->find('ID', $pageID);

        if (!$page) {
            return null;
        }

        $userguide = UserGuide::get()->find('DerivedClass', $page->ClassName);

        if (!$userguide) {
            return null;
        }

        return $userguide->Content;
    }

}
