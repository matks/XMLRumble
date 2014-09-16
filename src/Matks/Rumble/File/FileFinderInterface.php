<?php

namespace Matks\Rumble\File;

interface FileFinderInterface
{
	/**
	 * Find all files having the given extension
	 * @param  string $directory
	 * @param  string $extension
	 */
	public function findFilesWithExtension($directory, $extension);
}
