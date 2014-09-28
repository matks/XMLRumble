<?php

namespace Matks\Rumble\Yaml;

interface YamlWriterInterface
{
    public function writeYamlFile($dataNode, $filepath);
}
