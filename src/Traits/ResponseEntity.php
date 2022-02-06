<?php

namespace TDevAgency\CheckboxUa\Traits;

use DateTime;
use Exception;
use TDevAgency\CheckboxUa\Entities\Responses\OrganizationResponseEntity;

trait ResponseEntity
{
    use Arrayable;

    /**
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($value === null || ! property_exists(self::class, $key)) {
                continue;
            }
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
}
