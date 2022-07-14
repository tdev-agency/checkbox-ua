<?php

namespace TDevAgency\CheckboxUa\Tests;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;
use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;
use TDevAgency\CheckboxUa\Tags\Cashier;

class SingInRequestEntityExceptionTest extends TestCase
{

    /**
     * @return void
     */
    public function testIncorrectSignIn(): void
    {
        $this->expectException(PropertyValidationException::class);
        $entity = SignInRequestEntity::create([]);

    }

}
