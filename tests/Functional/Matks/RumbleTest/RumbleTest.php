<?php

namespace Matks\RumbleTest;

use Exception;

class RumbleTest
{

    /**
     * Get target test directory
     * 
     * @return string
     */
    public static function getTestDirectory()
    {
        return __DIR__ . '/../../../data/functional_test/xliff/';
    }

    /**
     * Get test resources directory
     * 
     * @return string
     */
    public static function getTestResourcesDirectory()
    {
        return __DIR__ . '/../../../data/functional_test/expected-yml/';
    }

    /**
     * Check written files content and delete them
     *
     * @throws Exception if result different from expected
     */
    public static function checkResults()
    {
        $testFilename1 = 'X-L-F.fr.yml';
        $testFilename2 = 'Stats.en.yml';

        $testDirectory = static::getTestDirectory();
        $testResourcesDirectory = static::getTestResourcesDirectory();

        $testCheckingList = array(
            $testDirectory.'/'.$testFilename1 => $testResourcesDirectory.'/'.$testFilename1,
            $testDirectory.'/folder/'.$testFilename2 => $testResourcesDirectory.'/'.$testFilename2
        );

        foreach ($testCheckingList as $createdFilepath => $expectedFilepath) {

            if (!file_exists($createdFilepath)) {
                throw new Exception("Error : cannot find file $createdFilepath");
            }

            if (file_get_contents($createdFilepath) !== file_get_contents($expectedFilepath)) {
                throw new Exception("Error : $createdFilepath different from $expectedFilepath");
            }
        }
    }
}
