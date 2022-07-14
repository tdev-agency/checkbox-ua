<?php

namespace TDevAgency\CheckboxUa\Traits;

use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;

trait HasRequiredProperties
{
    /**
     * @throws PropertyValidationException
     */
    protected function validateRequired(): void
    {
        if (empty($this->required)) {
            return;
        }

        foreach ($this->required as $property) {
            if (empty($this->$property)) {
                throw new PropertyValidationException("Property {$property} cannot be null");
            }
        }
    }
}
