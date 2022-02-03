<?php

namespace TDevAgency\CheckboxUa\Groups;

use GuzzleHttp\Exception\ClientException;
use TDevAgency\CheckboxUa\Entities\Responses\OrganizationReceiptSettingsResponseEntity;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;
use Throwable;

class Organization implements GroupInterface
{
    use Groupable;

    /**
     * @throws Throwable
     */
    public function receiptConfig(): OrganizationReceiptSettingsResponseEntity
    {
        $response = $this->getHttpClient()->get('organization/receipt-config');
        return new OrganizationReceiptSettingsResponseEntity($response);
    }

    /**
     * @throws Throwable
     */
    public function logoPng(): OrganizationReceiptSettingsResponseEntity
    {
        $response = $this->getHttpClient()->get('organization/logo.png');
        return new OrganizationReceiptSettingsResponseEntity($response);
    }

    /**
     * @throws Throwable
     */
    public function textLogoPng(): OrganizationReceiptSettingsResponseEntity
    {
        $response = $this->getHttpClient()->get('organization/text_logo.png');
        return new OrganizationReceiptSettingsResponseEntity($response);
    }
}
