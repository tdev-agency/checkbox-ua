<?php

namespace TDevAgency\CheckboxUa\Traits;

use DateTime;
use DateTimeInterface;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionProperty;
use TDevAgency\CheckboxUa\Entities\Responses\OrganizationResponseEntity;
use TDevAgency\CheckboxUa\Interfaces\ShiftStatusInterface;

trait ResponseEntity
{

    /**
     * @param  array $data
     * @throws Exception
     */
    public function __construct(array $data = [])
    {
        array_walk(
        /**
         * @throws Exception
         */            $data,
            function ($value, $key) {
                if ($value !== null && property_exists(self::class, $key)) {
                    if ($key === 'organization') {
                        $value = new OrganizationResponseEntity($value);
                    } elseif (in_array(
                        $key,
                        ['created_at', 'updated_at', 'subscription_exp', 'certificate_end', 'setup_date']
                    )
                    ) {
                        $value = new DateTime($value);
                    }

                    $this->$key = $value;
                }
            }
        );
    }

    public function toArray(): array
    {
        $reflect = new ReflectionClass(self::class);
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = [];
        foreach ($props as $prop) {
            $prop = $prop->getName();
            if ($this->$prop === null) {
                continue;
            }
            if ($this->$prop instanceof Arrayable) {
                $data[$prop] = $this->$prop->toArray();
            } elseif ($this->$prop instanceof DateTimeInterface) {
                $data[$prop] = $this->$prop->format('c');
            } elseif ($this->$prop instanceof ShiftStatusInterface) {
                $data[$prop] = $this->$prop->__toString();
            } else {
                $data[$prop] = $this->$prop;
            }
        }

        return $data;
    }
}
