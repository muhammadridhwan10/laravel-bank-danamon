<?php

namespace Ridhwan\LaravelBankDanamon;

use Ridhwan\Response\Exceptions\ConnectionException;
use Ridhwan\Response\Exceptions\RequestException;
use Ridhwan\Response\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class Danamon
{
    /**
     * API url
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * Application client Id
     *
     * @var string
     */
    protected $clientId;

    /**
     * Application client secret
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * apiKey
     *
     * @var mixed
     */
    private $apiKey;

    /**
     * apiSecret
     *
     * @var mixed
     */
    private $apiSecret;

    /**
     * token
     *
     * @var string
     */
    private $token;

    /**
     * servicePath
     *
     * @var string
     */
    private $servicePath = 'Ridhwan\\LaravelBankDanamon\\Services\\';

    /**
     * Init
     *
     * @param  mixed $token
     * @return void
     */
    public function __construct($token = null)
    {
        $this->apiUrl = config('bank-danamon.api_url');
        $this->clientId = config('bank-danamon.client_id');
        $this->clientSecret = config('bank-danamon.client_secret');
        $this->apiKey = config('bank-danamon.api_key');
        $this->apiSecret = config('bank-danamon.api_secret');
        $this->token = $token;
    }

    /**
     * sendRequest
     *
     * @param  string $httpMethod
     * @param  string $requestUrl
     * @param  array $options
     * @return \Ridhwan\Response\Response
     *
     * @throws \Ridhwan\Response\Exceptions\RequestException
     */
    public function sendRequest(string $httpMethod, string $relativeUrl, array $requestBody = [])
    {
        try {
            $options = ['http_errors' => false];

            if (!$this->token) {
                $options = array_merge($options, $requestBody);

            } else {

                $url = url_sort_lexicographically("{$httpMethod}:{$relativeUrl}");
                $timestamp = danamon_timestamp();
                ksort($requestBody);

                // set headers
                $options['headers'] = [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                    'BDI-Key' => $this->apiKey,
                    'BDI-Timestamp' => $timestamp,
                    'BDI-Signature' => 'f4e4d374c813fd1689bdb1bf1f51653f',
                ];

                $methods = ['POST', 'PUT', 'PATCH'];

                if (in_array($httpMethod, $methods)) {
                    $options['body'] = json_encode($requestBody, JSON_UNESCAPED_SLASHES);
                }
            }

            return tap(
                new Response(
                    (new Client())->request($httpMethod, $this->apiUrl . $relativeUrl, $options)
                ),
                function ($response) {
                    if (!$response->successful()) {
                        $response->throw();
                    }
                }
            );

        } catch (ConnectException $e) {
            throw new ConnectionException($e->getMessage(), 0, $e);
        } catch (RequestException $e) {
            return $e->response;
        }
    }

    /**
     * setToken
     *
     * @param  string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Dynamiclly bind class
     *
     * @param  string $serviceName
     * @return \Ridhwan\LaravelBankDanamon\Modules
     */
    public function service($serviceName)
    {
        $service = $this->servicePath . $serviceName;
        return new $service($this->token);
    }
}
