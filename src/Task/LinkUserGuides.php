<?php

namespace SilverStripe\UserGuide\Task;

use Parsedown;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\BuildTask;
use SilverStripe\UserGuide\Model\UserGuide;

class LinkUserGuides extends BuildTask
{
    private static $segment = 'LinkUserGuides';
    protected $title = 'Creates record links to user guides';

    public function run($request)
    {
        // get relations
        $guides = UserGuide::get();
        $config = Config::inst()->get('UserGuide', 'directory');

        $guideDirectory = '/docs/userguides/';
        $files = scandir($guideDirectory);
        $parsedown = new Parsedown();

        foreach ($files as $file) {
            $generateHTML = false;
            $guide = $guides->find('MarkdownPath', $file);
            if ($guide) {
                $guideLastMod = strtotime($guide->LastEdited);
                $fileLastMod = strtotime(filemtime($file));

                // we could create hash and compare if times are different, to see if content has indeed changed
                if ($fileLastMod > $guideLastMod) {
                    $generateHTML = true;
                }
            } else {
                $generateHTML = true;
                $guide = UserGuide::create();
                $guide->Title = $file;
            }

            if ($generateHTML) {
                $fileContent = file_get_contents($file);
                $htmlContent = $parsedown->text($fileContent);
                $guide->Content = $htmlContent;
                $guide->write();
            }
        }

    }
}
