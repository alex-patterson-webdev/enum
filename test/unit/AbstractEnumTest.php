<?php

declare(strict_types=1);

namespace ArpTest\Enum;

use Arp\Enum\AbstractEnum;
use Arp\Enum\EnumInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers  \Arp\Enum\AbstractEnum
 *
 * @author  Alex Patterson <alex.patterson.webdev@gmail.com>
 * @package ArpTest\Enum
 */
class AbstractEnumTest extends TestCase
{
    /**
     * @var EnumInterface
     */
    private EnumInterface $enum;

    public function setUp(): void
    {
        $this->enum = new class() extends AbstractEnum {
            public const FOO = -1;
            public const BAR = true;
            public const BAZ = 1.223;
            public const FAB = 'hello';
            public const FOB = 1234;
        };
    }

    /**
     * Assert the class implements EnumInterface
     */
    public function testImplementsEnumInterface(): void
    {
        $this->assertInstanceOf(EnumInterface::class, $this->enum);
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

    /**
     * Assert that toArray() will return a array map of the class constants
     */
    public function testToArray(): void
    {
        $expected = [
            'FOO' => -1,
            'BAR' => true,
            'BAZ' => 1.223,
            'FAB' => 'hello',
            'FOB' => 1234,
        ];

        $this->assertSame($expected, $this->enum::toArray());
    }

    /**
     * Assert calls to hasKey() return the expected bool
     */
    public function testHasKey(): void
    {
        $this->assertTrue($this->enum::hasKey('FOO'));
        $this->assertTrue($this->enum::hasKey('BAR'));
        $this->assertTrue($this->enum::hasKey('BAZ'));
        $this->assertFalse($this->enum::hasKey('HELLO'));
        $this->assertFalse($this->enum::hasKey('TEST'));
        $this->assertFalse($this->enum::hasKey('ABC'));
    }

    /**
     * Assert the result of getKeys()
     */
    public function testGetKeys(): void
    {
        $expected = [
            'FOO',
            'BAR',
            'BAZ',
            'FAB',
            'FOB',
        ];

        $this->assertSame($expected, $this->enum::getKeys());
    }

    /**
     * Assert the result of testGetValues()
     */
    public function testGetValues(): void
    {
        $expected = [
            -1,
            true,
            1.223,
            'hello',
            1234,
        ];

        $this->assertSame($expected, $this->enum::getValues());
    }

    /**
     * Assert that the class constant key can be returned by it's matched value, or NULL if non-existing
     *
     * @param mixed $expectedKey
     * @param mixed $value
     *
     * @dataProvider getKeyByValueData
     */
    public function testGetKeyByValue($expectedKey, $value): void
    {
        $this->assertSame($expectedKey, $this->enum::getKeyByValue($value));
    }

    /**
     * @return array[]
     */
    public function getKeyByValueData(): array
    {
        return [
            [
                'FOO',
                -1,
            ],
            [
                'BAR',
                true,
            ],
            [
                'FAB',
                'hello',
            ],
            [
                'BAZ',
                1.223,
            ],
            [
                null,
                'not-valid-vale',
            ],
            [
                null,
                0,
            ],
        ];
    }

    /**
     * Assert that the class constant value can be returned by it's matched key, or NULL if non-existing
     *
     * @param mixed  $expectedValue
     * @param string $key
     *
     * @dataProvider getValueByKeyData
     */
    public function testGetValueByKey($expectedValue, string $key): void
    {
        $this->assertSame($expectedValue, $this->enum::getValueByKey($key));
    }

    /**
     * @return array[]
     */
    public function getValueByKeyData(): array
    {
        return [
            [
                -1,
                'FOO',
            ],
            [
                true,
                'BAR',
            ],
            [
                'hello',
                'FAB',
            ],
            [
                1.223,
                'BAZ',
            ],
            [
                null,
                'testing-not-found-value',
            ],
        ];
    }
}
