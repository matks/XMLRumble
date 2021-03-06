<?php

namespace Matks\Rumble\tests\Units\File;

use Matks\Rumble\File;

use \atoum;

class FileFinder extends atoum
{
    public function testConstruct()
    {
        $finder = new File\FileFinder();
        $this
            ->class(get_class($finder))
                ->hasInterface('\Matks\Rumble\File\FileFinderInterface')
        ;
    }

    public function testFindFilesWithExtension()
    {
        $targetFolder = __DIR__.'/../../data/unit_test';

        $finder = new File\FileFinder();
        $result = $finder->findFilesWithExtension($targetFolder, 'xliff');

        $this
            ->array($result)
                ->hasSize(3)
        ;

        // trying to guess result with regex
        $filePattern = '#XMLRumble/tests/data/folder_xml/xliff.xliff#';
        $contentIsRight = (preg_match($filePattern, $result[0]) !== false);

        $this
            ->boolean($contentIsRight)
                ->isTrue()
        ;
    }

    public function testFindFilesWithExtensionBadArguments()
    {
        $finder = new File\FileFinder();

        $this
            ->exception(
                function () use ($finder) {
                    $result = $finder->findFilesWithExtension('lol', array(1));
                }
            )->hasMessage('Extension expected to be a string')
        ;

        $this
            ->exception(
                function () use ($finder) {
                    $result = $finder->findFilesWithExtension('lol', '.xliff');
                }
            )->hasMessage("Dots '.' are not allowed in extension")
        ;

        $this
            ->exception(
                function () use ($finder) {
                    $result = $finder->findFilesWithExtension('lol', 'xliff');
                }
            )->hasMessage('Not a directory: lol')
        ;
    }
}
