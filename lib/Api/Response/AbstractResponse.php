<?php

namespace BreweryDB\Api\Response;

/**
 * Response interface from BreweryDB API
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
abstract class AbstractResponse
{
    const SUCCESS = 'success';

    protected $response;
    protected $data;

    public function __construct(string $response)
    {
        if ($response === false) {
            $this->response['status'] = false;
            return;
        }

        $this->response = json_decode($response, true);
        if (!is_array($this->response)) {
            throw new \Exception("Not a valid JSON string");
        }
        $this->data = $this->response['data'] ?? null;
    }

    /**
     * Return if request is ok
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->response['status'] === self::SUCCESS ? true : false;
    }

    /**
     * Return error
     *
     * @return string
     */
    public function getError()
    {
        $error = null;
        if (!$this->isSuccess()) {
            $error = json_encode($this->response);
        }
        return $error;
    }

}