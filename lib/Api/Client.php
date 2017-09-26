<?php

namespace BreweryDB\Api;

use BreweryDB\Api\Response\BeersResponse;

/**
 * Allows communicate with BreweryDB API 
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
class Client 
{
    const API_URL = 'http://api.brewerydb.com/v2/';
    
    /**
     * API key
     *
     * @var string
     */
    protected $key;
    
    /**
     * Response format
     *
     * @var string
     */
    protected $format = 'json';

    
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Configure Curl connection properties and make a call
     *
     * @param array $parameters
     * @param string $endpoint
     */
    public function createCurl(array $parameters, string $endpoint) 
    {
        $parameters['key'] = $this->key;
        $parameters['format'] = $this->format;

        // Configure Curl connection properties
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, self::API_URL . $endpoint . '/?' . http_build_query($parameters));
        
        // Make a call and check status
        $result = curl_exec($ch);
        
        if (!$result) {
            throw new \Exception("Curl error: " . curl_error($ch));
        }
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($status > 400) {
            throw new \Exception("HTTP error #$status");
        }

        return $result;
    }

    /**
     * Get list of beers by glassware Id
     *
     * @param int $glasswareId
     * @return BeersResponse
     */
    public function getListOfBeers(int $glasswareId)
    {
        // One of the parameters must be set for non-premium user
        $parameters = [
            'glasswareId' => $glasswareId
        ];

        $response = $this->createCurl($parameters, 'beers');
        
        return new BeersResponse($response);
    }
}