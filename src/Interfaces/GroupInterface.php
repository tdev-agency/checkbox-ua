<?php

namespace TDevAgency\CheckboxUa\Interfaces;

use TDevAgency\CheckboxUa\HttpClient\HttpClient;

interface GroupInterface
{
    public static function create(HttpClient $client);
}
