<?php

namespace App\Component;

use App\Dto\PayrollOutputDto;
use App\Dto\PayrollOutputDtoInterface;
use App\Exceptions\PaydayCalculatorInvalidDataException;
use Carbon\Carbon;

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

        $payday = Carbon::create($year, $month)
            ->endOfMonth()
            ->subDay();

        if ($payday->dayOfWeek === Carbon::SATURDAY) {
            $payday->subDay();
        } elseif ($payday->dayOfWeek === Carbon::SUNDAY) {
            $payday->subDays(2);
        }

        return PayrollOutputDto::create(
            $payday->startOfDay(),
            $payday->copy()->subWeekdays(4)->startOfDay(),
        );
    }
}
