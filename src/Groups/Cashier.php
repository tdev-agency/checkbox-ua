<?php

namespace TDevAgency\CheckboxUa\Groups;

use Exception;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;
use Throwable;

class Cashier implements GroupInterface
{
    use Groupable;

    /**
     * @return MeResponseEntity
     * @throws Throwable
     */
    public function me(): MeResponseEntity
    {
        $data = $this->getHttpClient()->get('cashier/me');

        return new MeResponseEntity($data);
    }

    /**
     * @return ShiftResponseEntity
     * @throws NoOpenShiftException
     * @throws Throwable
     */
    public function shift(): ShiftResponseEntity
    {
        $data = $this->getHttpClient()->get('cashier/shift');

        if (empty($data)) {
            throw new NoOpenShiftException('Cashier.shift: Cashier shift is not opened');
        }

        return new ShiftResponseEntity($data);
    }

    /**
     * @return SignatureResponseEntity
     * @throws Throwable
     */
    public function checkSignature(): SignatureResponseEntity
    {
        $data = $this->getHttpClient()->get('cashier/check-signature');

        return new SignatureResponseEntity($data);
    }

    /**
     * @param SignInRequestEntity $entity
     * @return SignInResponseEntity
     * @throws Exception
     */
    public function signIn(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->getHttpClient()->post('cashier/signin', [
            'json' => [
                'login' => $entity->getLogin(),
                'password' => $entity->getPassword(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->getHttpClient()->setAccessToken($responseEntity->getAccessToken());

        return $responseEntity;
    }

    /**
     * @return bool
     * @throws Throwable
     */
    public function signOut(): bool
    {
        $this->getHttpClient()->post('cashier/signout');

        $this->getHttpClient()->setAccessToken(null);
        return true;
    }

    /**
     * @param SignInRequestEntity $entity
     * @return SignInResponseEntity
     * @throws Throwable
     */
    public function signInPinCode(SignInRequestEntity $entity): SignInResponseEntity
    {
        $data = $this->getHttpClient()->post('cashier/signinPinCode', [
            'headers' => [
                'X-License-Key' => $entity->getLicenseKey()
            ],
            'json' => [
                'pin_code' => $entity->getPinCode(),
            ]
        ]);

        $responseEntity = new SignInResponseEntity($data);

        $this->getHttpClient()->setAccessToken($responseEntity->getAccessToken());

        return $responseEntity;
    }
}
