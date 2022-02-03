<?php

namespace TDevAgency\CheckboxUa\Traits;

use TDevAgency\CheckboxUa\HttpClient\HttpClient;

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

    protected function getHttpClient(): HttpClient
    {
        return $this->client;
    }
}
