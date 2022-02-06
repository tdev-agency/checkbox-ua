<?php

namespace TDevAgency\CheckboxUa\Tests;

use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;
use Throwable;

class CashierTest extends TestCase
{
    /**
     * @return CheckboxUa
     * @throws PropertyValidationException
     */
    public function testSingInWithLoginPassword(): CheckboxUa
    {
        $entity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD'],
            'license_key' => $_ENV['LICENSE_KEY'],
        ]);
        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        return $client;
    }

    /**
     * @return CheckboxUa
     * @throws PropertyValidationException
     */
    public function testSingInWithPinCode(): CheckboxUa
    {
        $entity = SignInRequestEntity::create(['license_key' => $_ENV['LICENSE_KEY'], 'pin_code' => $_ENV['PIN_CODE']]);

        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN_PIN_CODE, $entity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        return $client;
    }

    /**
     * @depends testSingInWithLoginPassword
     * @param CheckboxUa $client
     * @return void
     * @throws Throwable
     */
    public function testMeWithLogin(CheckboxUa $client): void
    {
        $res = $client->getCashier()->me();
        $this->assertInstanceOf(MeResponseEntity::class, $res);
    }

    /**
     * @depends testSingInWithPinCode
     * @param CheckboxUa $client
     * @return void
     * @throws Throwable
     */
    public function testMeWithPinCode(CheckboxUa $client): void
    {
        $res = $client->getCashier()->me();
        $this->assertInstanceOf(MeResponseEntity::class, $res);
    }

    /**
     * @depends testSingInWithLoginPassword
     * @param CheckboxUa $client
     * @return void
     * @throws Throwable
     */
    public function testShift(CheckboxUa $client): void
    {
        try {
            $res = $client->getCashier()->shift();
            $this->assertInstanceOf(ShiftResponseEntity::class, $res);
        } catch (NoOpenShiftException $exception) {
            $this->assertInstanceOf(NoOpenShiftException::class, $exception);
        }
    }

    /**
     * @depends testSingInWithLoginPassword
     * @param CheckboxUa $client
     * @return void
     * @throws Throwable
     */
    public function testCheckSignature(CheckboxUa $client): void
    {
        $res = $client->getCashier()->checkSignature();
        $this->assertInstanceOf(SignatureResponseEntity::class, $res);
    }

    /**
     * @depends testSingInWithLoginPassword
     *
     * @param CheckboxUa $client
     * @return void
     * @throws Throwable
     */
    public function testSignOut(CheckboxUa $client): void
    {
        $this->assertIsBool($client->getCashier()->signOut());
    }

}
