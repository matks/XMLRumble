<?php

namespace Matks\Rumble;

use Matks\Rumble\File\FileFinderInterface;
use Matks\Rumble\Xliff\XliffReaderInterface;
use Matks\Rumble\Yaml\YamlWriterInterface;

use Matks\Rumble\Tools\RumbleTools as Tools;
use DateTime;
use Exception;

class Rumble
{
    private $targetDirectory;
    private $finder;
    private $xliffReader;
    private $yamlWriter;

    /**
	 * Constructor
	 * @param FileFinderInterface $finder
	 * @param string $directoryPath
	 */
    public function __construct(
        FileFinderInterface $finder,
        XliffReaderInterface $xliffReader,
        YamlWriterInterface $yamlWriter,
        $directoryPath)
    {
        $this->targetDirectory = $directoryPath;

        $this->finder = $finder;
        $this->xliffReader = $xliffReader;
        $this->yamlWriter = $yamlWriter;
    }

    /**
     * Execute Rumble processing
     */
    public function run()
    {
        $beginProcessingDate = new DateTime('now');

        $fileList = $this->getTargetFileList();
        $errors = [];
        $processedFiles = [];

        foreach ($fileList as $filepath) {

            try {
                $this->convertFile($filepath);
                $processedFiles[] = $filepath;
            } catch (Exception $e) {
                $errors[] = array(
                    'file' => $filepath,
                    'message' => $e->getMessage()
                );
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

    /**
     * Get list of files to process
     * @return array
     */
    private function getTargetFileList()
    {
        $list = $this->finder->findFilesWithExtension(
            $this->targetDirectory,
            FileFinderInterface::SYMFONY2_TRANSLATION_FILES_EXTENSION
        );

        return $list;
    }

    /**
     * Create a yaml file with the same translation data in the same directory
     * that the xliff file given
     *
     * @param string $filepath
     */
    private function convertFile($filepath)
    {
        $xmlNodeAsArray = $this->xliffReader->extractTranslationData($filepath);
        $yamlFilepath = Tools::computeYamlFilepath($filepath);
        $this->yamlWriter->writeYamlFile($xmlNodeAsArray, $yamlFilepath);
    }

    /**
     * Output processing report in the console
     *
     * @param array    $processedFiles
     * @param array    $errors
     * @param DateTime $beginProcessingDate
     * @param DateTime $endProcessingDate
     */
    private function outputResult(array $processedFiles, array $errors, DateTime $beginProcessingDate, DateTime $endProcessingDate)
    {
        echo "\033[32mXML RUMBLE REPORT: \033[0m".PHP_EOL;

        foreach ($processedFiles as $filepath) {
            echo '  * Done: '.$filepath.PHP_EOL;
        }

        foreach ($errors as $error) {
            echo '  * Failed: '.$error['file'].PHP_EOL;
            echo '    ~-> catched "'.$error['message'].'"'.PHP_EOL;
        }
    }
}
