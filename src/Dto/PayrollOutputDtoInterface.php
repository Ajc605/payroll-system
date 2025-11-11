<?php

namespace App\Dto;

use Carbon\Carbon;

interface PayrollOutputDtoInterface
{
    public static function create(Carbon $payday, Carbon $makePaymentDay): self;
    public function getPayday(): Carbon;
    public function getMakePaymentDay(): Carbon;
}
