<?php

namespace Mapo89\LaravelHeizreportApi\Tests\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class MockClientHelper
{
    /**
     * Creates a mocked Guzzle client with predefined responses.
     *
     * @param array $responses
     * @return Client
     */
    public static function create(array $responses): Client
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        return new Client(['handler' => $handlerStack]);
    }
}
