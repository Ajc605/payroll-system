<?php

namespace App\StateProcessor;

use ApiPlatform\Metadata\Exception\OperationNotFoundException;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Component\PaydayCalculatorInterface;
use App\Dto\PayrollInputDtoInterface;
use App\Dto\PayrollOutputDtoInterface;
use App\Exceptions\PaydayCalculatorInvalidDataException;
use Symfony\Component\Translation\Exception\InvalidResourceException;

final readonly class PayrollStateProcessor implements ProcessorInterface
{
    public function __construct(
        private PaydayCalculatorInterface $paydayCalculator,
    ) {
    }

    /**
    * @throws OperationNotFoundException
    * @throws InvalidResourceException
    * @throws PaydayCalculatorInvalidDataException
    */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): PayrollOutputDtoInterface {
        if (!$operation instanceof Post) {
            throw new OperationNotFoundException();
        }

        if (!$data instanceof PayrollInputDtoInterface) {
            throw new InvalidResourceException();
        }

        return $this->paydayCalculator->calculate(
            $data->getMonth(),
            $data->getYear(),
        );
    }
}
