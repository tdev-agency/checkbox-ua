<?php

namespace TDevAgency\CheckboxUa\Traits;

use TDevAgency\CheckboxUa\HttpClient;

trait Groupable
{
    private HttpClient $client;

    private function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public static function create(HttpClient $client): self
    {
        return new static($client);
    }

    public function getHttpClient(): HttpClient
    {
        return $this->client;
    }

}
