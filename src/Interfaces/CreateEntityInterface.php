<?php

namespace TDevAgency\CheckboxUa\Interfaces;

use Illuminate\Contracts\Support\Arrayable;

interface CreateEntityInterface extends Arrayable
{
    /**
     * @param array $data
     */
    public function __construct(array $data = []);

    /**
     * @param array $data
     * @return CreateEntityInterface
     */
    public static function create(array $data = []): CreateEntityInterface;
}
