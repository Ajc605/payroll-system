<?php

namespace App\Tests\Unit\StateProcessor;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Exception\OperationNotFoundException;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\State\ProcessorInterface;
use App\Component\PaydayCalculatorInterface;
use App\Dto\PayrollInputDto;
use App\Dto\PayrollInputDtoInterface;
use App\Dto\PayrollOutputDtoInterface;
use App\Exceptions\PaydayCalculatorInvalidDataException;
use App\StateProcessor\PayrollStateProcessor;
use App\Tests\TestCase\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Prophecy\Prophecy\ObjectProphecy;
use stdClass;
use Symfony\Component\Translation\Exception\InvalidResourceException;

final class PayrollStateProcessorTest extends UnitTestCase
{
    private ObjectProphecy|PaydayCalculatorInterface $paydayCalculator;
    private ProcessorInterface $sut;

    public function setUp(): void
    {
        $this->paydayCalculator = $this->prophesize(PaydayCalculatorInterface::class);

        $this->sut = new PayrollStateProcessor(
            $this->paydayCalculator->reveal(),
        );
    }

    #[DataProvider('exceptionIsThrownForOperationDataProvider')]
    public function test_exception_is_thrown_for_operation(Operation $operation): void
    {
        $this->expectException(OperationNotFoundException::class);

        $this->sut->process([], $operation);
    }

    public static function exceptionIsThrownForOperationDataProvider(): iterable
    {
        yield [new Get()];
        yield [new Put()];
        yield [new GetCollection()];
        yield [new Delete()];
        yield [new Patch()];
    }

    public function test_exception_is_thrown_for_invalid_data(): void
    {
        $this->expectException(InvalidResourceException::class);

        $this->sut->process(new stdClass(), new Post());
    }

    public function test_exception_is_thrown_by_payday_calculator(): void
    {
        $this->expectException(PaydayCalculatorInvalidDataException::class);

        $month = 1;
        $year = 1999;
        $data = $this->createPayrollInputDto($month, $year);

        $this->paydayCalculator->calculate($month, $year)
            ->willThrow(new PaydayCalculatorInvalidDataException());

        $this->sut->process($data, new Post());
    }

    public function test_processor_returns_payroll_output_dto(): void
    {
        $month = 1;
        $year = 1999;
        $data = $this->createPayrollInputDto($month, $year);
        $output = $this->prophesize(PayrollOutputDtoInterface::class)->reveal();

        $this->paydayCalculator->calculate($month, $year)
            ->shouldBeCalledOnce()
            ->willReturn($output);

        $this->assertSame(
            $output,
            $this->sut->process($data, new Post())
        );
    }


    private function createPayrollInputDto(
        int $month,
        int $year,
    ): PayrollInputDtoInterface {
        $input = $this->prophesize(PayrollInputDtoInterface::class);

        $input->getMonth()
            ->willReturn($month);
        $input->getYear()
            ->willReturn($year);

        return $input->reveal();
    }
}
