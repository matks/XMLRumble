<?php

namespace Matks\Rumble\Yaml;

use Symfony\Component\Yaml\Dumper;
use Exception;

class YamlWriter implements YamlWriterInterface
{
    /**
	 * @see http://symfony2-document.readthedocs.org/en/latest/components/yaml.html#id13
	 */
    const YAML_EXPANSION_LEVEL = 5;

    /**
	 * @var Dumper
	 */
    private $dumper;

    public function __construct()
    {
        $this->dumper = new Dumper();
    }

    /**
     * Write given data into yaml-formatted file
     *
     * @param array  $dataNode
     * @param string $filepath
     */
    public function writeYamlFile(array $dataNode, $filepath)
    {
        $this->validateFile($filepath);
        $this->writeFile($dataNode, $filepath);
    }

    /**
     * Validate given filepath
     *
     * @param  string    $filepath
     * @throws Exception
     */
    private function validateFile($filepath)
    {
        if (file_exists($filepath)) {
            throw new Exception("$filepath already exists");
        }

        if (!preg_match('#.'.YamlWriterInterface::YAML_FILES_EXTENSION.'#', $filepath)) {
            throw new Exception("$filepath has no .yml extension");
        }
    }

    /**
     * Write yaml file
     *
     * @param array  $data
     * @param string $filepath
     */
    private function writeFile(array $data, $filepath)
    {
        $yaml = $this->dumper->dump($data, static::YAML_EXPANSION_LEVEL);
        file_put_contents($filepath, $yaml);
    }

}
