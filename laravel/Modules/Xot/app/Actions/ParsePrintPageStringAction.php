<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Arr;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

use function Safe\preg_match_all;

/**
 * Parses a print page string into an array of page numbers.
 *
 * @example "1-4,6,7,8,11-14" becomes [1,2,3,4,6,7,8,11,12,13,14]
 */
class ParsePrintPageStringAction
{
    use QueueableAction;

    /**
     * Execute the page string parsing.
     *
     * @param  string  $str  The page range string to parse
     * @return array<int> Array of page numbers
     */
    public static function execute(string $str): array
    {
        $pattern = '/(\d+)(?:(?:-)(\d+))?(?:,(?!$))?/';
        $matches = [];
        preg_match_all($pattern, $str, $matches);

        Assert::notEmpty($matches[0], 'No valid page numbers found');
        $matchCount = count($matches[0]);
        $res = [];

        for ($i = 0; $i < $matchCount; $i++) {
            $firstNumber = Arr::get($matches, "1.{$i}");
            $secondNumber = Arr::get($matches, "2.{$i}");

            Assert::string($firstNumber, 'First number must be a string');
            Assert::string($secondNumber, 'Second number must be a string');

            if ($secondNumber === '') {
                $res[] = (int) $firstNumber;
            } else {
                $res = array_merge($res, self::fromTo((int) $firstNumber, (int) $secondNumber));
            }
        }

        return $res;
    }

    /**
     * Generate an array of numbers from start to end inclusive.
     *
     * @param  int  $from  Starting number
     * @param  int  $to  Ending number
     * @return array<int> Array of sequential numbers
     */
    public static function fromTo(int $from, int $to): array
    {
        Assert::greaterThanEq($to, $from, 'End number must be greater than or equal to start number');

        return range($from, $to);
    }
}
