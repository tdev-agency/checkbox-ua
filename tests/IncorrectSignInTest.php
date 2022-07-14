<?php

namespace TDevAgency\CheckboxUa\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;
use TDevAgency\CheckboxUa\Tags\Cashier;

class IncorrectSignInTest extends TestCase
{

    /**
     * @return void
     */
    public function testIncorrectSignIn(): void
    {
        $this->expectException(ForbiddenException::class);
        $entity = SignInRequestEntity::create([
            'login' => Factory::create()->userName(),
            'password' => Factory::create()->password(),
            'license_key' => $_ENV['LICENSE_KEY']
        ]);
        new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity);
    }

}
