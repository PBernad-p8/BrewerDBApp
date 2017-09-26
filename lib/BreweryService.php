<?php
namespace BreweryDB;

use BreweryDB\Api\Client;
use BreweryDB\Utilities;
use BreweryDB\XmlConverter;

/**
 * Get list of beers and store in the file 
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
class BreweryService
{
    const JSON = 'json';

    public $format;
    public $fileName = 'listOfBeers';

    public function run()
    {
        try {
            $list = $this->getList();
            $this->setFormat();
            if ($this->format === 'json'  || $this->format === 'both') {
                Utilities::logIntoFile(json_encode($list), $this->fileName . '.' . self::JSON);
            } 
            
            if ($this->format === 'xml' || $this->format === 'both') {
                $xmlConverter = new XmlConverter();
                $xmlConverter->logIntoXmlFile($list, $this->fileName);
            }
        } catch ( \Exception $ex) {
            Utilities::println($ex->getMessage());
        }
    }

    /**
     * Get list of beers
     *
     */
    private function getList()
    {
        $client = new Client(KEY);
        $response = $client->getListOfBeers(5);

        if (!$response->isSuccess()) {
            throw new \Exception('API returned error when trying to getListOfBeers: ' . $response->getError());
        }

        return $response->getData();
    }

    /**
     * Set format type
     *
     */
    private function setFormat()
    {
        $format = getopt("f:");

        if (!isset($format['f'])) {
            throw new \Exception ('Format not provided');
        }

        if ($format['f'] !== 'json' && $format['f'] !== 'xml' && $format['f'] !== 'both') {
            throw new \Exception ('Choose one of format types: json, xml or both');
        }
        $this->format = strtolower($format['f']);
    }
}