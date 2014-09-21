<?php

namespace Matks\Rumble\tests\Units\Xliff;

use Matks\Rumble\Xliff;

use \atoum;

class XliffReader extends atoum
{
    public function testConstruct()
    {
        // just check that the instance can be created without problems
        $reader = new Xliff\XliffReader();
    }

    public function testExtractTranslationData()
    {
        $reader = new Xliff\XliffReader();
        $filepath = __DIR__.'/../../data/unit_test/test-xliff-reader-1.xliff';

        $result = $reader->extractTranslationData($filepath);
        $expectedArray = array(
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

        $this
            ->array($result)
                ->isEqualTo($expectedArray)
        ;
    }

    public function testExtractTranslationDataBadCases()
    {
        $reader = new Xliff\XliffReader();
        $filepath = 'nowhere';

        $this
            ->exception(
                function () use ($reader, $filepath) {
                    $result = $reader->extractTranslationData($filepath);
                }
            )->hasMessage('No file at nowhere')
        ;

        $filepath = __DIR__.'/../../data/unit_test/test-xliff-reader-2.xliff';

        $this
            ->exception(
                function () use ($reader, $filepath) {
                    $result = $reader->extractTranslationData($filepath);
                }
            )->hasMessage('Node missing required attribute')
        ;

        $filepath = __DIR__.'/../../data/unit_test/test-xliff-reader-3.xliff';

        $this
            ->exception(
                function () use ($reader, $filepath) {
                    $result = $reader->extractTranslationData($filepath);
                }
            )->hasMessage('Node a.b.e missing required child')
        ;
    }
}
