<?php

namespace TDevAgency\CheckboxUa\Traits;


trait Createable
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if (! property_exists(self::class, $key)) {
                continue;
            }
            $this->$key = $value;
        }
    }

    public static function create(array $data): self
    {
        return new static($data);
    }

}
