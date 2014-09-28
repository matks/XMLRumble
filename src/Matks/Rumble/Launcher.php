<?php

namespace Matks\Rumble;

use Matks\Rumble\File\FileFinder;
use Matks\Rumble\Xliff\XliffReader;
use Matks\Rumble\Yaml\YamlWriter;
use Exception;

/**
 * Rumble Script launcher
 *
 * Create and configure Rumble before running it
 */
class Launcher
{
    const CONFIGURATION_KEY_DIRECTORY = 'directoryPath';

    /**
	 * Main function
	 * @param array $configuration
	 */
    public static function main($configuration = null)
    {
        self::validateConfiguration($configuration);
        $rumble = static::setup($configuration);

        $rumble->run();
    }

    /**
	 * Construct Rumble instance
	 * @param array $configuration
	 * @return Rumble
	 */
    private static function setup($configuration)
    {
        $directoryPath = $configuration[static::CONFIGURATION_KEY_DIRECTORY];

        $finder = new FileFinder();
        $xmlReader = new XliffReader();
        $yamlWriter = new YamlWriter();
        $rumble = new Rumble($finder, $xmlReader, $yamlWriter, $directoryPath);

        return $rumble;
    }

    /**
	 * Validate configuration array
	 * @param  array $configuration
	 * @throws Exception
	 */
    private static function validateConfiguration($configuration)
    {
        if (!is_array($configuration)) {
            throw new Exception("Configuration must be an array");
        }

        $configurationKeys = array(
            static::CONFIGURATION_KEY_DIRECTORY
        );

        foreach ($configurationKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $configuration)) {
                throw new Exception("Configuration not valid");
            }
        }
    }
}
