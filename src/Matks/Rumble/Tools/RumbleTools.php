<?php

namespace Matks\Rumble\Tools;

use Matks\Rumble\File\FileFinderInterface;
use Matks\Rumble\Yaml\YamlWriterInterface;

use Matks\Rumble\Rumble;

class RumbleTools
{
    /**
	 * Compute the Yaml filepath from the xliff filepath given
	 *
	 * @param  string $filepath
	 * @return string
	 */
    public static function computeYamlFilepath($filepath)
    {
        if (!preg_match('#.'.FileFinderInterface::SYMFONY2_TRANSLATION_FILES_EXTENSION.'#', $filepath)) {
            throw new Exception("$filepath has wrong xliff extension");
        }

        $directoryPath = dirname($filepath);
        $filename = basename($filepath);
        $filenameWithoutExtension = static::removeFileExtension($filename);

        $yamlFilepath = $directoryPath . '/' . $filenameWithoutExtension . '.' . YamlWriterInterface::YAML_FILES_EXTENSION;

        return $yamlFilepath;
    }

    /**
     * Thanks claviska
     * @link http://www.abeautifulsite.net/php-functions-to-get-and-remove-the-file-extension-from-a-string/
     */
    public static function removeFileExtension($filename)
    {
        return preg_replace('/.[^.]*$/', '', $filename);
    }
}
