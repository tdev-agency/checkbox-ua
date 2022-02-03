<?php

namespace TDevAgency\CheckboxUa\Groups;


use Exception;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\HttpClient;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;

class Cashier implements GroupInterface
{
    use Groupable;

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function me(): MeResponseEntity
    {
        $data = $this->getHttpClient()->request('cashier/me');

        return new MeResponseEntity($data);
    }

    /**
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     * @throws NoOpenShiftException
     * @throws Exception
     */
    public function shift(): ShiftResponseEntity
    {
        $data = $this->getHttpClient()->request('cashier/shift');

        if ($data === null) {
            throw new NoOpenShiftException('Cashier.shift: Cashier shift is not opened');
        }

        return new ShiftResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function checkSignature(): SignatureResponseEntity
    {
        $data = $this->getHttpClient()->request('cashier/check-signature');

        return new SignatureResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signIn(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->getHttpClient()->request('cashier/signin', 'POST', [
            'json' => [
                'login' => $entity->getLogin(),
                'password' => $entity->getPassword(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->getHttpClient()->setAccessToken($responseEntity);

        return $responseEntity;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signOut(): bool
    {
        $this->getHttpClient()->request('cashier/signout', 'POST');

        return true;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signInPinCode(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->getHttpClient()->request('cashier/signinPinCode', 'POST', [
            'headers' => [
                'X-License-Key' => $entity->getLicenseKey()
            ],
            'json' => [
                'pin_code' => $entity->getPinCode(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->getHttpClient()->setAccessToken($responseEntity);

        return $responseEntity;
    }
}
