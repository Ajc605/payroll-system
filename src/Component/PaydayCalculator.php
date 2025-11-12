<?php

namespace App\Component;

use App\Dto\PayrollOutputDto;
use App\Dto\PayrollOutputDtoInterface;
use App\Exceptions\PaydayCalculatorInvalidDataException;
use Carbon\Carbon;
use Cmixin\BusinessDay;

final readonly class PaydayCalculator implements PaydayCalculatorInterface
{
    /**
    * @inheritDoc
    */
    public function calculate(
        int $month,
        int $year
    ): PayrollOutputDtoInterface {
        if(
            $month <= 0
            || $year <= 0
        ) {
            throw new PaydayCalculatorInvalidDataException();
        }

        BusinessDay::enable(Carbon::class);
        Carbon::setHolidaysRegion('gb-national');

        $payday = Carbon::create($year, $month)
            ->endOfMonth()
            ->subDay();

        while (!$payday->isBusinessDay()) {
            $payday = $payday->previousBusinessDay();
        }

        return PayrollOutputDto::create(
            $payday->startOfDay(),
            $payday->copy()->subBusinessDays(4)->startOfDay(),
        );
    }
}
