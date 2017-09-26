<?php
namespace BreweryDB;

use BreweryDB\Utilities;


/**
 * Convert array into xml file
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
class XmlConverter
{
    /**
     * Convert an array to xml file
     *
     * @param array $array
     * @param string $filename
     */
    public function logIntoXmlFile(array $array, string $filename)
    {
        $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><listOfBeers></listOfBeers>");
        $this->addToXml($array, $xml);

        Utilities::println('Generating a file with a list...');
        $xmlFile = $xml->asXML(LIST_DIR . "/$filename.xml");

        if (!$xmlFile) {
            throw new \Exception('XML file generation error.');
        }
        Utilities::println('Successfully!!!');
    }

    private function addToXml($array, &$xml)
    {
        foreach($array as $key => $value) {
            if (is_array($value)) {
                if(!is_numeric($key)){
                    $subnode = $xml->addChild("$key");
                    $this->addToXml($value, $subnode);
                }else{
                    $subnode = $xml->addChild("item$key");
                    $this->addToXml($value, $subnode);
                }
            } else {
                $xml->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }

}