<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Arrayable;
use TDevAgency\CheckboxUa\Traits\Createable;

class ShiftCloseRequestEntity implements CreateEntityInterface
{
    use Arrayable;
    use Createable;

    private bool $skip_client_name_check = false;
    private ?ReportRequestEntity $report = null;
    private ?string $fiscal_code = null;
    private ?string $fiscal_date = null;
}
