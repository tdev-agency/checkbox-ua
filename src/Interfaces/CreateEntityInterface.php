<?php

namespace TDevAgency\CheckboxUa\Interfaces;

interface CreateEntityInterface
{
    public function __construct(array $data);

    public static function create(array $data): CreateEntityInterface;
}
