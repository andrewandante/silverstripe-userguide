<?php

namespace SilverStripe\UserGuide\Task;

use DOMDocument;
use Parsedown;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\BuildTask;
use SilverStripe\UserGuide\Model\UserGuide;

class TransformUserGuides extends BuildTask
{
    private static $segment = 'TransformUserGuides';
    protected $title = 'Transform user guides';

    public function run($request)
    {
        $guides = UserGuide::get();
        $configDir = Config::inst()->get('UserGuide', 'directory') ?: '/docs/userguides/';
        $guideDirectory = BASE_PATH . $configDir;


        if (!is_dir($guideDirectory)) {
            $this->log($configDir . ' does not exist - no user docs found');
            return;
        }

        // Find all .md files in the Guide Directory
        $directoryIterator = new RecursiveDirectoryIterator($guideDirectory);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $files = new RegexIterator($iterator, '/^.*\.(md|html)$/i', RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {
            $fileType = pathinfo($file[0], PATHINFO_EXTENSION);

            $file = $file[0];
            $guide = $guides->find('MarkdownPath', $file);

            if (is_null($guide)) {
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

            $htmlContent = "";
            $fileContents = file_get_contents($file);
            if ($fileType === 'html') {
                $htmlContent = $fileContents;
            }

            if ($fileType === 'md') {
                // prototyping
                // Not sure if this is a good idea
                if (strstr($fileContents, '@UserDocs_Skip')) {
                    $fileContents = str_replace('@UserDocs_Skip=', '', $fileContents);
                    $this->log('@UserDocs_Skip found - skip ' . $file);
                    continue;
                }

                $derivedClass = trim(str_replace('@UserDocs_Class_Name=', '', strstr($fileContents, '@UserDocs_Class_Name=')));
                if ($derivedClass) {
                    if (ClassInfo::exists($derivedClass)) {
                        $guide->DerivedClass = $derivedClass;
                    }

                    $fileContents = str_replace('@UserDocs_Class_Name=' . $derivedClass, '', $fileContents);
                }

                $htmlContent = Parsedown::instance()
                    ->setSafeMode(true)
                    ->setBreaksEnabled(true)
                    ->text($fileContents);
            }

            // transform any urls that do not have an https:// we can assume they are relative links
            $htmlDocument = new DOMDocument();
            $htmlDocument->loadHTML($htmlContent);
            $links = $htmlDocument->getElementsByTagName('a');
            $siteURL = Director::absoluteBaseURL();

            foreach ($links as $link) {
                $linkHref = $link->getAttribute("href");

                if (str_contains($linkHref, 'http') == false) {
                    $link->setAttribute('href', $siteURL . 'userguides/' . $linkHref);
                    $this->log('changed: ' . $linkHref . ' to: ' . $link->getAttribute("href"));
                }
            }

            $guide->Content = $htmlContent;
            $guide->write();
            $this->log($file . ' was written');
        }
    }

    protected function log($message) {
        echo $message . (Director::is_cli() ? PHP_EOL : '<br>');
    }
}
