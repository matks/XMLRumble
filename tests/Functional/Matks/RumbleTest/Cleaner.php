<?php

namespace Matks\RumbleTest;

use Symfony\Component\Finder\Finder;
use Matks\RumbleTest\RumbleTest as Test;

class Cleaner
{
    /**
	 * Find all .yml files in given test directory and delete them
	 */
    public function cleanTestDirectory()
    {
        $directory = Test::getTestDirectory();

        $finder = new Finder();
        $finder->in($directory)->name('*.yml');

        foreach ($finder as $file) {
            unlink($file);
        }
    }
}
