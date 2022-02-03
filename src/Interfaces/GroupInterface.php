<?php

namespace TDevAgency\CheckboxUa\Interfaces;

use TDevAgency\CheckboxUa\HttpClient;

interface GroupInterface
{
    public static function create(HttpClient $client);

    public function getHttpClient(): HttpClient;

}
