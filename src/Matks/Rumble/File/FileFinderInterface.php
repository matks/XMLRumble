<?php

namespace Matks\Rumble\File;

interface FileFinderInterface
{
    const SYMFONY2_TRANSLATION_FILES_EXTENSION = 'xliff';

    /**
	 * Find all files having the given extension
	 * @param  string $directory
	 * @param  string $extension
	 */
    public function findFilesWithExtension($directory, $extension);
}
