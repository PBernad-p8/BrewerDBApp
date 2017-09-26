<?php

namespace BreweryDB\Api\Response;

/**
 * Response interface from BreweryDB API
 *
 * @author Piotr Bernad <bernad.p4@gmail.com>
 */
class BeersResponse extends AbstractResponse
{
    const NO_NAME = 'NO_NAME';
    const NO_DESCRIPTION = 'NO_DESCRIPTION';
    const NO_URL = 'NO_URL';

    /**
     * Returns response data
     *
     * @return array
     */
    public function getData()
    {
        foreach ($this->data as $data) {
            $name = $data['name'] ?? self::NO_NAME;
            $description = $data['description'] ?? self::NO_DESCRIPTION;
            $label = $data['labels']['large'] ?? self::NO_URL;
            $item = [
                'name' => $name,
                'description' => $description,
                'label' => $label
            ];
            
            $items[] = $item;
        }
        return $items;
    }
}