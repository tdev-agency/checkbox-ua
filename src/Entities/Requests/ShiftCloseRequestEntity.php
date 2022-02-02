<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Createable;
use TDevAgency\CheckboxUa\Traits\RequestEntity;

class ShiftCloseRequestEntity implements Arrayable, CreateEntityInterface
{
    use RequestEntity;
    use Createable;

    private bool $skip_client_name_check = false;
    private ?ReportRequestEntity $report = null;
    private ?string $fiscal_code = null;
    private ?string $fiscal_date = null;


}
