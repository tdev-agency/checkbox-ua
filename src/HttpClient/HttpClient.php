<?php

namespace TDevAgency\CheckboxUa\HttpClient;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;
use TDevAgency\CheckboxUa\Exceptions\NotFoundException;
use TDevAgency\CheckboxUa\Exceptions\UnauthorizedException;
use TDevAgency\CheckboxUa\Exceptions\UnprocessableEntityException;
use TDevAgency\CheckboxUa\Groups\Cashier;
use Throwable;

final class HttpClient
{

    private const LIVE_API = 'https://api.checkbox.ua/api/v1/';

    private const DEV_API = 'https://dev-api.checkbox.in.ua/api/v1/';

    private GuzzleHttpClient $http;
    private array $options = ['headers' => []];
    private Cashier $cashier;
    private ?SignInRequestEntity $signInRequestEntity = null;
    private ?string $signInDriver = null;

    public function __construct(bool $isDevMode = false)
    {
        $this->http = new GuzzleHttpClient([
            'base_uri' => ! $isDevMode ? self::LIVE_API : self::DEV_API,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function get(string $uri, array $options = []): ?array
    {
        return $this->request($uri, 'GET', $options);
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $options
     * @param bool $catRetry
     * @return mixed
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws Throwable
     * @throws UnauthorizedException
     * @throws UnprocessableEntityException
     * @throws GuzzleException
     */
    private function request(
        $uri,
        string $method = 'GET',
        array $options = [],
        bool $catRetry = true
    ): ?array {
        $options['headers'] = $this->options['headers'];
        try {
            $contents = $this->http->request($method, $uri, $options)->getBody()->getContents();
        } catch (ClientException $clientException) {
            if ($clientException->getCode() === 401) {
                if ($catRetry && $this->signInDriver !== null && $this->signInRequestEntity !== null) {
                    $this->cashier->{$this->signInDriver}($this->signInRequestEntity);
                    return $this->request($uri, $method, $options, false);
                }
                $this->proceedSignOut()
                    ->proceedException($clientException);
            } else {
                $this->proceedException($clientException);
            }
        }

        if (empty($contents)) {
            throw new RuntimeException(
                'Empty response'
            );
        }
        return $this->getJson($contents);
    }

    /**
     * @throws NotFoundException
     * @throws UnprocessableEntityException
     * @throws UnauthorizedException
     * @throws ForbiddenException
     */
    private function proceedException(ClientException $exception): void
    {
        $contents = $exception->getResponse()->getBody()->getContents();

        if ($exception->getCode() === 403) {
            throw new ForbiddenException($contents);
        }
        if ($exception->getCode() === 401) {
            throw new UnauthorizedException($contents);
        }
        if ($exception->getCode() === 404) {
            throw new NotFoundException($contents);
        }
        if ($exception->getCode() === 422) {
            throw new UnprocessableEntityException($contents);
        }

        throw $exception;
    }

    /**
     * @return $this
     */
    public function proceedSignOut(): HttpClient
    {
        $this->options['headers'] = [];
        $this->signInRequestEntity = null;
        $this->signInDriver = null;

        return $this;
    }

    /**
     * @param string $contents
     * @return array
     */
    private function getJson(string $contents): ?array
    {
        $decodedContents = json_decode($contents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'Error trying to decode response: '.
                json_last_error_msg()
            );
        }

        return $decodedContents;
    }

    /**
     * @param string $uri
     * @param array $options
     * @return array
     * @throws Throwable
     */
    public function post(string $uri, array $options = []): ?array
    {
        return $this->request($uri, 'POST', $options);
    }

    /**
     * @param string|null $accessToken
     * @return $this
     */
    public function setAccessToken(?string $accessToken = null): HttpClient
    {
        $this->options['headers']['Authorization'] = 'Bearer '.$accessToken;
        return $this;
    }

    /**
     * @param string $licenseKey
     * @return $this
     */
    public function setLicenseKey(string $licenseKey): HttpClient
    {
        $this->options['headers']['X-License-Key'] = $licenseKey;
        return $this;
    }

    /**
     * @param Cashier $cashier
     * @param SignInRequestEntity $signInRequestEntity
     * @param string $signInDriver
     * @return $this
     */
    public function setCashier(
        Cashier $cashier,
        SignInRequestEntity $signInRequestEntity,
        string $signInDriver
    ): HttpClient {
        $this->cashier = $cashier;
        $this->signInRequestEntity = $signInRequestEntity;
        $this->signInDriver = $signInDriver;

        return $this;
    }
}


