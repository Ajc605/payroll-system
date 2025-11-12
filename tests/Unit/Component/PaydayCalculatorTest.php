<?php

namespace App\Tests\Unit\Component;

use App\Component\PaydayCalculator;
use App\Component\PaydayCalculatorInterface;
use App\Dto\PayrollOutputDto;
use App\Exceptions\PaydayCalculatorInvalidDataException;
use App\Tests\TestCase\UnitTestCase;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;

final class PaydayCalculatorTest extends UnitTestCase
{
    private PaydayCalculatorInterface $sut;

    public function setUp(): void
    {
        $this->sut = new PaydayCalculator();
    }

    #[DataProvider('exceptionIsThrownDueToInputDataProvider')]
    public function test_exception_is_thrown_due_to_input(
        int $month,
        int $year,
    ): void {
        $this->expectException(PaydayCalculatorInvalidDataException::class);

        $this->sut->calculate($month, $year);
    }

    public static function exceptionIsThrownDueToInputDataProvider(): iterable
    {
        yield [0, 0];
        yield [0, 1];
        yield [1, 0];
    }

    #[DataProvider('correctDatesAreCalculatedDataProvider')]
    public function test_correct_dates_are_calculated(
        int $month,
        int $year,
        Carbon $payday,
        Carbon $makePaymentDay,
    ) {
        $expected = PayrollOutputDto::create($payday, $makePaymentDay);

        $this->assertEquals(
            $expected,
            $this->sut->calculate($month, $year)
        );
    }

    public static function correctDatesAreCalculatedDataProvider(): iterable
    {
        yield [
            1,
            2025,
            Carbon::create(2025, 1, 30),
            Carbon::create(2025, 1, 24)
        ];
        yield [
            2,
            2025,
            Carbon::create(2025, 2, 27),
            Carbon::create(2025, 2, 21)
        ];
        yield [
            3,
            2025,
            Carbon::create(2025, 3, 28),
            Carbon::create(2025, 3, 24)
        ];
        yield [
            4,
            2025,
            Carbon::create(2025, 4, 29),
            Carbon::create(2025, 4, 23)
        ];
        yield [
            5,
            2025,
            Carbon::create(2025, 5, 30),
            Carbon::create(2025, 5, 23)
        ];
        yield [
            6,
            2025,
            Carbon::create(2025, 6, 27),
            Carbon::create(2025, 6, 23)
        ];
        yield [
            7,
            2025,
            Carbon::create(2025, 7, 30),
            Carbon::create(2025, 7, 24)
        ];
        yield [
            8,
            2025,
            Carbon::create(2025, 8, 29),
            Carbon::create(2025, 8, 25)
        ];
        yield [
            9,
            2025,
            Carbon::create(2025, 9, 29),
            Carbon::create(2025, 9, 23)
        ];
        yield [
            10,
            2025,
            Carbon::create(2025, 10, 30),
            Carbon::create(2025, 10, 24)
        ];
        yield [
            11,
            2025,
            Carbon::create(2025, 11, 28),
            Carbon::create(2025, 11, 24)
        ];
        yield [
            12,
            2025,
            Carbon::create(2025, 12, 30),
            Carbon::create(2025, 12, 22)
        ];
    }
}
