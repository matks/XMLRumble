<?php

namespace Matks\Rumble\File;

use Symfony\Component\Finder\Finder;
use Exception;

class FileFinder implements FileFinderInterface
{
    /**
	 * @var Finder
	 */
    private $finder;

    public function __construct()
    {
        $this->finder = new Finder();
    }

    /**
	 * Find all files having the given extension
     *
	 * @param  string $directory
	 * @param  string $extension
	 * @return array
	 */
    public function findFilesWithExtension($directory, $extension)
    {
        $this->validateInput($directory, $extension);

        $this->finder->in($directory)
                     ->name('*.'.$extension)
        ;

        $results = $this->getFinderResult();

        return $results;
    }

    /**
	 * Validate input
     *
	 * @param  string $directory
	 * @param  string $extension
	 * @throws Exception
	 */
    private function validateInput($directory, $extension)
    {
        if (!is_string($extension)) {
            throw new Exception("Extension expected to be a string");
        }

        if (strpos($extension,'.') !== false) {
            throw new Exception("Dots '.' are not allowed in extension");
        }

        if (!is_dir($directory)) {
            throw new Exception("Not a directory: $directory");
        }
    }

    /**
     * Extract filepaths from finder results
     *
     * @return array
     */
    private function getFinderResult()
    {
        $results = array();

        foreach ($this->finder as $result) {
            $results[] = $result->getRealPath();
        }

        return $results;
    }
}
