<?php

namespace TDevAgency\CheckboxUa\Tests;

use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Responses\OrganizationReceiptSettingsResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NotFoundException;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Tags\Organization;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use Throwable;

class OrganizationTest extends TestCase
{

    public function testAuthorizeClient(): GroupInterface
    {
        $signInRequestEntity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD'],
            'license_key' => $_ENV['LICENSE_KEY']
        ]);
        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $signInRequestEntity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        return $client->make(Organization::class);
    }

    /**
     * @depends testAuthorizeClient
     */
    public function testReceiptConfig(Organization $organization): void
    {
        $this->assertInstanceOf(OrganizationReceiptSettingsResponseEntity::class, $organization->receiptConfig());
    }

    /**
     * @depends testAuthorizeClient
     */
    public function testLogoPng(Organization $organization): void
    {
        try {
            $this->assertInstanceOf(OrganizationReceiptSettingsResponseEntity::class, $organization->logoPng());
        } catch (Throwable $exception) {
            $this->assertInstanceOf(NotFoundException::class, $exception);
        }
    }

    /**
     * @depends testAuthorizeClient
     */
    public function testTextLogoPng(Organization $organization): void
    {
        try {
            $this->assertInstanceOf(OrganizationReceiptSettingsResponseEntity::class, $organization->textLogoPng());
        } catch (Throwable $exception) {
            $this->assertInstanceOf(NotFoundException::class, $exception);
        }
    }
}
