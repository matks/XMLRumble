<?php

namespace Matks\Rumble\tests\Units\Tools;

use Matks\Rumble\Tools;

use \atoum;

class RumbleTools extends atoum
{
    public function testComputeYamlFilepath()
    {
        $filepath1 = '/a/b/c/lol.xliff';
        $filepath2 = 'do.xliff';
        $filepath3 = 'no.a.c-char.xliff';

        $this
            ->string(Tools\RumbleTools::computeYamlFilepath($filepath1))
                ->isIdenticalTo('/a/b/c/lol.yml')
            ->string(Tools\RumbleTools::computeYamlFilepath($filepath2))
                ->isIdenticalTo('./do.yml')
            ->string(Tools\RumbleTools::computeYamlFilepath($filepath3))
                ->isIdenticalTo('./no.a.c-char.yml')
        ;
    }
}
