<?php

namespace App\Tests\Integration;

use App\Tests\TestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PayrollTest extends JsonApiTestCase
{
    public function test_post_payroll_with_valid_data(): void
    {
        $response = $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                    'year' => 2025,
                ],
            ],
        );

        $this->assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertSame(
            [
                'payday' => '2025-11-28T00:00:00+00:00',
                'makePaymentDay' => '2025-11-24T00:00:00+00:00',

            ],
            $response->toArray(),
        );
    }

    public function test_post_payroll_with_invalid_data(): void
    {
        $response = $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 0,
                    'year' => 0,
                ],
            ],
        );

        $this->assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function test_post_payroll_with_invalid_month_zero(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 0,
                    'year' => 2025,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_month_too_high(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 13,
                    'year' => 2025,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_month_negative(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => -1,
                    'year' => 2025,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_year_zero(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                    'year' => 0,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_year_too_low(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                    'year' => 1999,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_year_too_high(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                    'year' => 2101,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_missing_month(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'year' => 2025,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_missing_year(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_empty_body(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_month_type(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 'invalid',
                    'year' => 2025,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_with_invalid_year_type(): void
    {
        $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 11,
                    'year' => 'invalid',
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_post_payroll_validates_both_fields_together(): void
    {

        $response = $this->client->request(
            Request::METHOD_POST,
            '/api/payrolls',
            [
                'json' => [
                    'month' => 0,
                    'year' => 0,
                ],
            ],
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
