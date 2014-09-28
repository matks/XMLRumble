<?php

namespace Matks\Rumble\Yaml;

interface YamlWriterInterface
{
    const YAML_FILES_EXTENSION = 'yml';

    public function writeYamlFile(array $dataNode, $filepath);
}
