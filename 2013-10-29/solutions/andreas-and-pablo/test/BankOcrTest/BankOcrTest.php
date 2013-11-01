<?php

namespace BankOcrTest;

use BankOcr\BankOcr;
use PHPUnit_Framework_TestCase;

require_once '../../src/BankOcr/BankOcr.php';

class BankCodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BankOcr
     */
    protected $bankOcr;

    protected function setUp()
    {
        $this->bankOcr = new BankOcr();
    }

    /**
     * @dataProvider providerTest0
     *
     * @param $input
     * @param $expected
     */
    public function test0($expected, $input)
    {
        $this->assertEquals(
            $expected,
            $this->bankOcr->convertAccountNumber($input)
        );
    }

    /**
     * @return array
     */
    public function providerTest0()
    {
        return [
            [
                '123456789',
                implode(
                    PHP_EOL,
                    [
                        '    _  _     _  _  _  _  _ ',
                        '  | _| _||_||_ |_   ||_||_|',
                        '  ||_  _|  | _||_|  ||_| _|',
                        '                           ',
                    ]
                ),
            ],
        ];
    }

    /**
     * @dataProvider providerValidateEntryValidatesEntry
     *
     * @param string $entry
     * @param bool   $isValid
     */
    public function testValidateEntryValidatesEntry($entry, $isValid)
    {
        $this->assertSame(
            $isValid,
            $this->bankOcr->isValid($entry)
        );
    }

    /**
     * @return array
     */
    public function providerValidateEntryValidatesEntry()
    {
        return [
            [
                implode(
                    PHP_EOL,
                    [
                        '    _  _     _  _  _  _  _ ',
                        '  | _| _||_||_ |_   ||_||_|',
                        '  ||_  _|  | _||_|  ||_| _|',
                        '                           ',
                    ]
                ),
                true,
            ],
            [
                implode(
                    PHP_EOL,
                    [
                        '    _  _     _  _  _  _  _',
                        '  | _| _||_||_ |_   ||_||_|',
                        '  ||_  _|  | _||_|  ||_| _|',
                        '                           ',
                    ]
                ),
                false,
            ],
        ];
    }

    /**
     * @dataProvider providerConvertDigitConvertsDigit
     *
     * @param mixed $expected
     * @param int   $digit
     */
    public function testConvertDigitConvertsDigit($expected, $digit)
    {
        $this->assertSame(
            $expected,
            $this->bankOcr->convertDigit($digit)
        );
    }

    /**
     * @return array
     */
    public function providerConvertDigitConvertsDigit()
    {
        return [
            [
                1,
                implode(
                    PHP_EOL,
                    [
                        '   ',
                        '  |',
                        '  |',
                        '   ',
                    ]
                )
            ],
            [
                2,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        ' _|',
                        '|_',
                        '   ',
                    ]
                ),
            ],
            [
                3,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        ' _|',
                        ' _|',
                        '   ',
                    ]
                ),
            ],
            [
                4,
                implode(
                    PHP_EOL,
                    [
                        '   ',
                        '|_|',
                        '  |',
                        '   ',
                    ]
                ),
            ],
            [
                5,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        '|_ ',
                        ' _|',
                        '   ',
                    ]
                ),
            ],
            [
                6,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        '|_ ',
                        '|_|',
                        '   ',
                    ]
                ),
            ],
            [
                7,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        '  |',
                        '  |',
                        '   ',
                    ]
                ),
            ],
            [
                8,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        '|_|',
                        '|_|',
                        '   ',
                    ]
                ),
            ],
            [
                9,
                implode(
                    PHP_EOL,
                    [
                        ' _ ',
                        '|_|',
                        ' _|',
                        '   ',
                    ]
                ),
            ],
        ];
    }

    /**
     * @dataProvider  providerConvertsCombinedDigits
     */
    public function testConvertsCombinedDigits($expected, $input)
    {
        $this->assertSame(
            $expected,
            $this->bankOcr->convertDigits($input)
        );
    }

    /**
     * @return array
     */
    public function providerConvertsCombinedDigits()
    {
        return [
            [
                12,
                implode(
                    PHP_EOL,
                    [
                        '    _ ',
                        '  | _|',
                        '  ||_ ',
                        '      ',
                    ]
                ),
            ]
        ];
    }
}
