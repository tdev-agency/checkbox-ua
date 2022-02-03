<?php

namespace TDevAgency\CheckboxUa\Traits;

trait Createable
{
    public function __construct(array $data)
    {
        $this->setData($data);
    }

    protected function setData($data): self
    {
        foreach ($data as $key => $value) {
            if (! property_exists(self::class, $key)) {
                continue;
            }
            $this->$key = $value;
        }
        return $this;
    }

    public static function create(array $data): self
    {
        return new static($data);
    }

}
