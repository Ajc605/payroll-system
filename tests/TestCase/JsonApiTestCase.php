<?php

namespace App\Tests\TestCase;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

abstract class JsonApiTestCase extends ApiTestCase
{
    protected $client;

    protected function setUp(): void
    {
        static::$alwaysBootKernel = true;

        $this->client = static::createClient([], [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }
}
