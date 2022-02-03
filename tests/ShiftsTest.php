<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use JsonException;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\Exceptions\OpenedShiftException;
use TDevAgency\CheckboxUa\Groups\Shifts;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use Throwable;

class ShiftsTest extends TestCase
{

    public function testAuthorizeClient(): GroupInterface
    {
        $signInRequestEntity = SignInRequestEntity::create(
            [
                'login' => $_ENV['LOGIN'],
                'password' => $_ENV['PASSWORD'],
                'license_key' => $_ENV['LICENSE_KEY']
            ]
        );
        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $signInRequestEntity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        return $client->make(Shifts::class);
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws Throwable
     */
    public function testCloseShift(Shifts $shifts): void
    {
        try {
            $this->assertInstanceOf(ShiftResponseEntity::class, $shifts->closeShift());
        } catch (NoOpenShiftException $exception) {
            $this->assertInstanceOf(NoOpenShiftException::class, $exception);
        }
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws Throwable
     */
    public function testCreateShift(Shifts $shifts): void
    {
        try {
            $this->assertInstanceOf(ShiftResponseEntity::class, $shifts->createShift());
        } catch (OpenedShiftException $exception) {
            $this->assertInstanceOf(OpenedShiftException::class, $exception);
        }
    }


    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetShifts(Shifts $shifts): void
    {
        $result = $shifts->getShifts();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
