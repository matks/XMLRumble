<?php

namespace Matks\Rumble\Xliff;

use SimpleXmlReader;

use Exception;

class XliffReader implements XliffReaderInterface
{

    const TRANSLATION_NODE_XPATH = 'xliff/file/body/trans-unit';
    const ID_NAME = 'id';
    const REFERENCE_NAME = 'resname';

    const RESNAME_DELIMITER = '.';

    /**
	 * Extract translation data from given xliff file
	 *
	 * @param  string $filepath       absolute file path
	 * @return array
     *
	 * @throws XliffNotValidException
	 *
	 */
    public function extractTranslationData($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("No file at $filepath");
        }

        $xmlAsString = file_get_contents($filepath);
        $xml = SimpleXmlReader\SimpleXmlReader::openFromString($xmlAsString);

        $translationNodes = $xml->path(static::TRANSLATION_NODE_XPATH);

        $extractedNodeData = array();

        foreach ($translationNodes as $node) {
            $extractedNodeData = $this->processNode($extractedNodeData, $node);
        }

        return $extractedNodeData;
    }

    /**
	 * Process xliff translation data node and add its data to the result array
	 *
	 * @param  array $extractedNodeData array result
	 * @param  SimpleXMLElement $node
	 * @return array
	 */
    private function processNode($extractedNodeData, $node)
    {
        // attributes validation
        $resname = (string) $node->attributes()->resname;
        $id = (string) $node->attributes()->id;

        if (($resname === '') || ($id === '')) {
            throw new XliffNotValidException('Node missing required attribute');
        }

        // children validation
        $source = (string) $node->source;
        $target = (string) $node->target;

        if (($source === '') || ($target === '')) {
            throw new XliffNotValidException('Node '.$resname.' missing required child');
        }

        // extract node data
        $levelKeys = $this->convertResnameIntoArrayKey($resname);
        $result = $this->addNodeIntoResultArray($levelKeys, $target, $extractedNodeData);

        return $result;
    }

    /**
	 * Convert reference name into keys array
	 *
	 * @param  string $resname
	 * @return array
	 */
    private function convertResnameIntoArrayKey($resname)
    {
        $levels = explode(static::RESNAME_DELIMITER, $resname);

        return $levels;
    }

    /**
	 * Add node data into extracted data array
	 *
	 * @param array $keys
	 * @param string $value
	 * @param array $array
	 */
    private function addNodeIntoResultArray($keys, $value, $array)
    {
        $newArray = $this->buildNodeArray($keys, $value);
        $combinedArray = array_merge_recursive($newArray, $array);

        return $combinedArray;
    }

    /**
	 * Recursive function to build an array with multiple sub-keys
	 *
	 * For example, keys a.b.c will built: array('a' => array('b' => array('c' => $value)))
	 *
	 * @param array  $keys
	 * @param string $value
	 */
    private function buildNodeArray($keys, $value)
    {
        if (count($keys) > 0) {
            $firstKey = array_shift($keys);

            $node = $this->buildNodeArray($keys, $value);
            $result = array($firstKey => $node);
        } else {
            $result = $value;
        }

        return $result;
    }

}
