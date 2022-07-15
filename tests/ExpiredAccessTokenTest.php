<?php

namespace TDevAgency\CheckboxUa\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Tags\Cashier;
use Throwable;

class ExpiredAccessTokenTest extends TestCase
{

    /**
     * @return void
     * @throws Throwable
     */
    public function testExpiredAccessToken(): void
    {
        $entity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD'],
            'license_key' => $_ENV['LICENSE_KEY']
        ]);
        /**
         * @var Cashier $cashier ;
         */
        $client = (new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity, Factory::create()->password(32)));

        $this->assertInstanceOf(MeResponseEntity::class, $client->make(Cashier::class)->me());
    }

}
