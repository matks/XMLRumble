<?php

namespace Matks\Rumble;

use Matks\Rumble\File\FileFinderInterface;

class Rumble
{
	const SYMFONY2_TRANSLATION_FILES_EXTENSION = 'xliff';

	/**
	 * Constructor
	 * @param FileFinderInterface $finder
	 * @param string $directoryPath
	 */
	public function __construct(FileFinderInterface $finder, $directoryPath)
	{
		$this->finder = $finder;
		$this->targetDirectory = $directoryPath;
	}

	public function run()
	{
		$fileList = $this->getTargetFileList();
	}

	private function getTargetFileList()
	{
		$list = $this->finder->findFilesWithExtension(
			$this->targetDirectory,
			self::SYMFONY2_TRANSLATION_FILES_EXTENSION
		);

		return $list;
	}
}
