<?php

namespace App\Tests\TestCase;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

abstract class UnitTestCase extends TestCase
{
    use ProphecyTrait;
}
