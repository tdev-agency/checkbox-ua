<?php

namespace TDevAgency\CheckboxUa\Traits;

use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;

trait Createable
{
    use HasRequiredProperties;

    /**
     * @throws PropertyValidationException
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->setData($data)
                ->validateRequired();
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    protected function setData(array $data = []): self
    {
        foreach ($data as $key => $value) {
            if (!property_exists(self::class, $key)) {
                continue;
            }
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * @throws PropertyValidationException
     */
    public static function create(array $data = []): self
    {
        return new static($data);
    }
}
