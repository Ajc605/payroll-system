<?php

namespace App\Component;

use App\Dto\PayrollOutputDtoInterface;
use App\Exceptions\PaydayCalculatorInvalidDataException;

interface PaydayCalculatorInterface
{
    /**
    * @throws PaydayCalculatorInvalidDataException
    */
    public function calculate(int $month, int $year): PayrollOutputDtoInterface;
}
