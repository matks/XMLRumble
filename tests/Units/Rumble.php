<?php

namespace Matks\Rumble\tests\Units;

use Matks\Rumble as RumbleNamespace;

use Mock;
use \atoum;

class Rumble extends atoum
{
    public function testConstruct()
    {
        $finderMock = new Mock\Matks\Rumble\File\FileFinderInterface();
        $xliffReaderMock = new Mock\Matks\Rumble\Xliff\XliffReaderInterface();

        // just check that the instance can be created without problems
        $rumble = new RumbleNamespace\Rumble($finderMock, $xliffReaderMock, '/');
    }
}
