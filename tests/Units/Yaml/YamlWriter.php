<?php

namespace Matks\Rumble\tests\Units\Yaml;

use Matks\Rumble\Yaml;

use \atoum;

class YamlWriter extends atoum
{
    public function testConstruct()
    {
        $writer = new Yaml\YamlWriter();
        $this
            ->class(get_class($writer))
                ->hasInterface('\Matks\Rumble\Yaml\YamlWriterInterface')
        ;
    }

    public function testWriteYamlFile()
    {
        $testDataArray = array(
            'c'  => 'Title',
            'aa' => array('aaa' => 'Design'),
            'a'  => array(
                'd' => 'ABC',
                'b' => array(
                    'e' => 'Foo2',
                    'c' => 'Foo'
                )
            )
        );

        $targetFilepath = __DIR__.'/../../data/unit_test/test-yaml-writer.yml';
        $expectedFilepath = __DIR__.'/../../data/unit_test/test-yaml-writer-expected.yml';

        $writer = new Yaml\YamlWriter();
        $writer->writeYamlFile($testDataArray, $targetFilepath);

        $resultFile = file_get_contents($targetFilepath);
        $expectedFile = file_get_contents($expectedFilepath);

        $this
            ->boolean(file_exists($targetFilepath))
                ->isTrue()
            ->string($resultFile)
                ->isEqualTo($expectedFile)
        ;

        $this->deleteTestFile($targetFilepath);
    }

    public function testWriteYamlFileBadCases()
    {
        $filepath1 = __DIR__.'a';
        $filepath2 = __DIR__.'/../../data/unit_test/test-yaml-writer-expected.yml';

        $writer = new Yaml\YamlWriter();

        $this
            ->exception(
                function () use ($writer, $filepath1) {
                    $writer->writeYamlFile(array(), $filepath1);
                }
            )->hasMessage("$filepath1 has no .yml extension")
        ;

        $this
            ->exception(
                function () use ($writer, $filepath2) {
                    $writer->writeYamlFile(array(), $filepath2);
                }
            )->hasMessage("$filepath2 already exists")
        ;
    }

    private function deleteTestFile($filepath)
    {
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }
}
