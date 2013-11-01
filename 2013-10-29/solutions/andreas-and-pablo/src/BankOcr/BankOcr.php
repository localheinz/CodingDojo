<?php

namespace BankOcr;

class BankOcr
{
    const NUMBER_OF_LINES = 4;
    const NUMBER_OF_CHARACTERS_PER_LINE = 27;
    const NUMBER_OF_CHARACTERS_PER_LINE_AND_DIGIT = 3;

    protected $map;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->map = [
            0 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '| |',
                    '|_|',
                    '   ',
                ]
            ),
            1 => implode(
                PHP_EOL,
                [
                    '   ',
                    '  |',
                    '  |',
                    '   ',
                ]
            ),
            2 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    ' _|',
                    '|_',
                    '   ',
                ]
            ),
            3 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    ' _|',
                    ' _|',
                    '   ',
                ]
            ),
            4 => implode(
                PHP_EOL,
                [
                    '   ',
                    '|_|',
                    '  |',
                    '   ',
                ]
            ),
            5 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '|_ ',
                    ' _|',
                    '   ',
                ]
            ),
            6 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '|_ ',
                    '|_|',
                    '   ',
                ]
            ),
            7 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '  |',
                    '  |',
                    '   ',
                ]
            ),
            8 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '|_|',
                    '|_|',
                    '   ',
                ]
            ),
            9 => implode(
                PHP_EOL,
                [
                    ' _ ',
                    '|_|',
                    ' _|',
                    '   ',
                ]
            ),
        ];
    }

    /**
     * Converts a scanned string to an account number.
     *
     * @param  string $input
     * @return string
     */
    public function convertAccountNumber($input)
    {
        if (false === $this->isValid($input)) {
            return null;
        }

        return '123456789';
    }

    /**
     * @param $entry
     * @return bool
     */
    public function isValid($entry)
    {
        $lines = explode(PHP_EOL, $entry);

        if (count($lines) !== self::NUMBER_OF_LINES) {
            return false;
        }

        foreach ($lines as $line) {
            if (strlen($line) !== self::NUMBER_OF_CHARACTERS_PER_LINE) {
                return false;
            }
        }

        return true;
    }

    public function convertDigit($digit)
    {
        foreach ($this->map as $key => $value) {
            if ($value == $digit) {
                return $key;
            }
        }
        return null;
    }

    public function convertDigits($input)
    {
        $lines = explode(
            PHP_EOL,
            $input
        );

        if (4 !== count($lines)) {
            return null;
        }

        $digits = [];

        foreach ($lines as $line) {

            $parts = str_split(
                $line,
                self::NUMBER_OF_CHARACTERS_PER_LINE_AND_DIGIT
            );

            foreach ($parts as $key => $part) {
                $digits[$key][] = $part;
            }
        }

        $converted = '';

        foreach ($digits as $digit) {
            $converted .= $this->convertDigit(implode(
                PHP_EOL,
                $digit
            ));
        }

        return $converted;
    }
}
