<?php

namespace Matks\Rumble;

use Matks\Rumble\File\FileFinderInterface;
use Matks\Rumble\Xliff\XliffReaderInterface;

use DateTime;
use Exception;

class Rumble
{
	const SYMFONY2_TRANSLATION_FILES_EXTENSION = 'xliff';

	/**
	 * Constructor
	 * @param FileFinderInterface $finder
	 * @param string $directoryPath
	 */
	public function __construct(FileFinderInterface $finder, XliffReaderInterface $xliffReader, $directoryPath)
	{
		$this->finder = $finder;
		$this->targetDirectory = $directoryPath;
		$this->xliffReader = $xliffReader;
	}

	public function run()
	{
		$beginProcessingDate = new DateTime('now');

		$fileList = $this->getTargetFileList();

		foreach ($fileList as $filepath) {

			$errors = [];
			$processedFiles = [];

			try {
				$this->convertFile($filepath);
				$processedFiles[] = $filepath;
			} catch (Exception $e) {
				$errors[] = array('file' => $filepath, 'message' => $e->getMessage());
			}
		}

		$endProcessingDate = new DateTime('now');
		$this->outputResult(
			$processedFiles,
			$errors,
			$beginProcessingDate,
			$endProcessingDate
		);
	}

	private function getTargetFileList()
	{
		$list = $this->finder->findFilesWithExtension(
			$this->targetDirectory,
			self::SYMFONY2_TRANSLATION_FILES_EXTENSION
		);

		return $list;
	}

	private function convertFile($filepath)
	{

	}

	private function outputResult(array $processedFiles, array $errors, DateTime $beginProcessingDate, DateTime $endProcessingDate)
	{
		foreach ($processedFiles as $filepath) {
			echo 'Done: '.$filepath.PHP_EOL;
		}

		foreach ($errors as $error) {
			echo 'Failed: '.$error['file'].PHP_EOL;
			echo '~-> catched "'.$error['message'].'"'.PHP_EOL;
		}
	}
}
