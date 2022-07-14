<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class SignInResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $type;
    private string $token_type;
    private string $access_token;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }
}
