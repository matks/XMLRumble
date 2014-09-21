<?php

namespace Matks\Rumble\Xliff;

use Matks\Rumble\Xliff\XliffReaderInterface;


interface XliffReaderInterface
{
	public function extractTranslationData($filepath);
}