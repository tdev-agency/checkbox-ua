<?php

namespace TDevAgency\CheckboxUa\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;
use TDevAgency\CheckboxUa\Exceptions\UnauthorizedException;
use TDevAgency\CheckboxUa\Groups\Cashier;

class IncorrectAccessTokenTest extends TestCase
{

    public function testIncorrectSignIn()
    {
        $this->expectException(UnauthorizedException::class);
        $entity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD']
        ]);
        /**
         * @var Cashier $cashier ;
         */
        $cashier = (new CheckboxUa())->make(Cashier::class);
        $cashier->signIn($entity);
        $signInResponseEntity = new SignInResponseEntity(
            [
                'type' => 'Bearer',
                'token_type' => 'Bearer',
                'access_token' => Factory::create()->password(32)
            ]
        );
        $cashier->getHttpClient()->setAccessToken($signInResponseEntity);
        $cashier->me();
    }

}
