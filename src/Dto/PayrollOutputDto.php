<?php

namespace App\Dto;

use Carbon\Carbon;

final class PayrollOutputDto implements PayrollOutputDtoInterface
{
    private function __construct(
        private Carbon $payday,
        private Carbon $makePaymentDay,
    ) {
    }

    public static function create(
        Carbon $payday,
        Carbon $makePaymentDay,
    ): static {
        return new self($payday, $makePaymentDay);
    }

    public function getPayday(): Carbon
    {
        return $this->payday;
    }

    public function getMakePaymentDay(): Carbon
    {
        return $this->makePaymentDay;
    }
}
