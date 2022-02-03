<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use JsonException;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Groups\Cashier;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Groups\Shifts;

class ShiftsTest extends TestCase
{

    public function testAuthorizeClient()
    {
        $client = new CheckboxUa();
        $this->assertInstanceOf(CheckboxUa::class, $client);
        $signInRequestEntity = SignInRequestEntity::create(
            ['login' => $_ENV['LOGIN'], 'password' => $_ENV['PASSWORD']]
        );
        $signInResponseEntity = $client->make(Cashier::class)->signIn($signInRequestEntity);
        $this->assertInstanceOf(SignInResponseEntity::class, $signInResponseEntity);
        return $client->make(Shifts::class);
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     */
    public function testCloseShift(Shifts $shifts): void
    {
        $result = $shifts->closeShift();
        $this->assertInstanceOf(ShiftResponseEntity::class, $result);
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testCreateShift(Shifts $shifts): void
    {
//        $signInRequestEntity = SignInRequestEntity::create(['license_key' => $_ENV['LICENSE_KEY']]);
//        $result = $shifts->createShift($signInRequestEntity);
//        $this->assertInstanceOf(ShiftResponseEntity::class, $result);
    }


    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetShifts(Shifts $shifts)
    {
        $result = $shifts->getShifts();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
