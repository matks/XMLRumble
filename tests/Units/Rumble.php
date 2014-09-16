<?php

namespace Matks\Rumble\Tests\Units;

use Matks\Rumble as RumbleNamespace;

use Mock; 
use \atoum;
 

class Rumble extends atoum
{
    public function testConstruct()
    {
        $finderMock = new Mock\Matks\Rumble\File\FileFinderInterface();

        // just check that the instance can be created without problems
        $rumble = new RumbleNamespace\Rumble($finderMock, '/');
    }
}
