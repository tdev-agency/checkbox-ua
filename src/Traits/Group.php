<?php

namespace TDevAgency\CheckboxUa\Traits;

use TDevAgency\CheckboxUa\Client;

trait Group
{
    private Client $client;


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

}
