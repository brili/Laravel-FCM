<?php

namespace LaravelFCM\Request;

/**
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * @internal
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @internal
     *
     * @var array
     */
    protected $config;

    protected $dynamicConfig;

    /**
     * BaseRequest constructor.
     */
    public function __construct($dConfig)
    {
        $this->$dynamicConfig = $dConfig;
        $this->config = app('config')->get('fcm.http', []);
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildRequestHeader()
    {
        return [
            'Authorization' => 'key='.$this->dynamicConfig['server_key'],
            'Content-Type' => 'application/json',
            'project_id' => $this->dynamicConfig['sender_id'],
        ];
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build()
    {
        return [
            'headers' => $this->buildRequestHeader(),
            'json' => $this->buildBody(),
        ];
    }
}
