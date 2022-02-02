<?php

namespace TDevAgency\CheckboxUa\Groups;


use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use TDevAgency\CheckboxUa\Client;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;

class Cashier
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function me(): MeResponseEntity
    {
        $data = $this->client->request('cashier/me');

        return new MeResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function shift(): ShiftResponseEntity
    {
        $data = $this->client->request('cashier/shift');

        if ($data === null) {
            throw new RuntimeException('Cashier.shift: Cashier shift is not opened');
        }

        return new ShiftResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function checkSignature(): SignatureResponseEntity
    {
        $data = $this->client->request('cashier/check-signature');

        return new SignatureResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signIn(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->client->request('cashier/signin', 'POST', [
            'json' => [
                'login' => $entity->getLogin(),
                'password' => $entity->getPassword(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->client->setAccessToken($responseEntity);

        return $responseEntity;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signOut(): bool
    {
        $this->client->request('cashier/signout', 'POST');

        return true;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signInPinCode(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->client->request('cashier/signinPinCode', 'POST', [
            'headers' => [
                'X-License-Key' => $entity->getLicenseKey()
            ],
            'json' => [
                'pin_code' => $entity->getPinCode(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->client->setAccessToken($responseEntity);

        return $responseEntity;
    }
}
