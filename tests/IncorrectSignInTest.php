<?php

namespace TDevAgency\CheckboxUa\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;
use TDevAgency\CheckboxUa\Groups\Cashier;

class IncorrectSignInTest extends TestCase
{

    public function testIncorrectSignIn()
    {
        $this->expectException(ForbiddenException::class);
        $entity = SignInRequestEntity::create([
            'login' => Factory::create()->userName(),
            'password' => Factory::create()->password()
        ]);
        (new CheckboxUa())->make(Cashier::class)->signIn($entity);
    }

}
