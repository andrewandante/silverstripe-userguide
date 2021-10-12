<?php

namespace SilverStripe\UserGuide\Task;

use Parsedown;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\BuildTask;
use SilverStripe\UserGuide\Model\UserGuide;

class LinkUserGuides extends BuildTask
{
    private static $segment = 'LinkUserGuides';
    protected $title = 'Creates record links to user guides';

    public function run($request)
    {
        $guides = UserGuide::get();
        $configDir = Config::inst()->get('UserGuide', 'directory') ?: '/docs/userguides/';
        $guideDirectory = BASE_PATH . $configDir;

        // Find all .md files in the Guide Directory
        $directoryIterator = new RecursiveDirectoryIterator($guideDirectory);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $files = new RegexIterator($iterator, '/^.+\.md$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {
            $generateHTML = false;
            $file = $file[0];
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
                $guide->Title = basename($file);
                $guide->MarkdownPath = $file;

                // Attempt to derive class from directory structure a la templates
                $classCandidate = str_replace(
                    DIRECTORY_SEPARATOR,
                    '\\',
                    substr($file, strlen($guideDirectory), -strlen('.md'))
                );

                if (ClassInfo::exists($classCandidate)) {
                    $guide->DerivedClass = $classCandidate;
                }
            }

            if ($generateHTML) {
                $htmlContent = Parsedown::instance()
                    ->setSafeMode(true)
                    ->setBreaksEnabled(true)
                    ->parse(file_get_contents($file));
                $guide->Content = $htmlContent;
                $guide->write();
            }
        }

    }
}
