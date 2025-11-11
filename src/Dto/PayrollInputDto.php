<?php

namespace App\Dto;

final class PayrollInputDto implements PayrollInputDtoInterface
{
    private int $month = 0;
    private int $year = 0;

    public function setMonth(int $month): void
    {
        $this->month = $month;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
