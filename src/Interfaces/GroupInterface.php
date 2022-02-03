<?php

namespace TDevAgency\CheckboxUa\Interfaces;

use TDevAgency\CheckboxUa\HttpClient\HttpClient;

interface GroupInterface
{
    public function __construct(HttpClient $client);

    public static function create(HttpClient $client): GroupInterface;
}
