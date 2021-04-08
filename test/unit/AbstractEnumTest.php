<?php

declare(strict_types=1);

namespace ArpTest\Enum;

use Arp\Enum\AbstractEnum;
use Arp\Enum\EnumInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Arp\Enum\AbstractEnum
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\Enum
 */
class AbstractEnumTest extends TestCase
{
    /**
     * Assert the class implements EnumInterface
     */
    public function testImplementsEnumInterface(): void
    {
        $enum = new class(1) extends AbstractEnum {
            public const TRUE = 1;
            public const FALSE = 0;
            public const MAYBE = 2;
        };

        $this->assertInstanceOf(EnumInterface::class, $enum);
    }

    /**
     * Assert the class implements EnumInterface
     */
    public function testWillThrowInvalidArgumentException(): void
    {
        $invalidValue = 123;

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('The value \'%s\' for enum class', $invalidValue)
        );

        new class($invalidValue) extends AbstractEnum {
            public const TRUE = 1;
            public const FALSE = 0;
            public const MAYBE = 2;
        };
    }
}
