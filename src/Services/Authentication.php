<?php

namespace Ridhwan\LaravelBankDanamon\Services;

use Ridhwan\LaravelBankDanamon\Danamon;

class Authentication extends Danamon
{
    /**
     * AccessToken
     *
     * @return \Ridhwan\Response\Response
     */
    public function AccessToken()
    {
        $requestUrl = '/api/oauth/token';
        return $this->sendRequest('POST', $requestUrl, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
            ],
        ]);
    }
}
