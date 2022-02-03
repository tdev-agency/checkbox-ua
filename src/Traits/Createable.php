<?php

namespace TDevAgency\CheckboxUa\Traits;

use ReflectionProperty;
use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;

trait Createable
{
    /**
     * @throws PropertyValidationException
     */
    public function __construct(array $data)
    {
        $this->setData($data)
            ->validateRequired();
    }

    /**
     * @throws PropertyValidationException
     */
    protected function validateRequired(): void
    {
        if (! property_exists(self::class, 'required') || empty($this->required)) {
            return;
        }

        foreach ($this->required as $property) {
            if (! isset($this->$property)) {
                throw new PropertyValidationException("Property {$property} cannot be null");
            }
        }
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

    /**
     * @throws PropertyValidationException
     */
    public static function create(array $data): self
    {
        return new static($data);
    }

}
