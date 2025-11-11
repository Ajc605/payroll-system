<?php

namespace App\Dto;

interface PayrollInputDtoInterface
{
    public function setMonth(int $month): void;
    public function getMonth(): int;
    public function setYear(int $year): void;
    public function getYear(): int;
}
