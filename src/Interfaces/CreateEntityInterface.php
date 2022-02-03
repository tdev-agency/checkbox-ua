<?php

namespace TDevAgency\CheckboxUa\Interfaces;

interface CreateEntityInterface
{
    /**
     * @param array $data
     */
    public function __construct(array $data);

    /**
     * @param array $data
     * @return CreateEntityInterface
     */
    public static function create(array $data): CreateEntityInterface;
}
