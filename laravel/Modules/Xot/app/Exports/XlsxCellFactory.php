<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Cell\EmptyCell;
use OpenSpout\Common\Entity\Cell\ErrorCell;
use OpenSpout\Common\Entity\Cell\FormulaCell;
use OpenSpout\Common\Entity\Cell\NumericCell;
use OpenSpout\Common\Entity\Cell\StringCell;
use OpenSpout\Common\Entity\Style\Style;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;
use Webmozart\Assert\Assert;

/**
 * Cella OpenSpout con lo stesso tipo e valore che PhpSpreadsheet darebbe alla
 * stessa stringa (`DefaultValueBinder::bindValue` + `Cell::setValueExplicit`):
 * cosi' l'xlsx del job nativo Filament (`export_xlsx`) coincide con quello di
 * Laravel-Excel (`export_xls`). Story Ptv/5.165.
 */
class XlsxCellFactory
{
    /**
     * UTF-8 sanificato (byte invalidi → U+FFFD), poi `dataTypeForValue()`:
     * numerica → `NumericCell` (`0 + $value`, quindi float oltre int64; `"007"`
     * resta testo), `''` → `EmptyCell` (PhpSpreadsheet non scrive la cella),
     * `=...` → `FormulaCell` (stessa esposizione dei due canali, decisione
     * condivisa in follow-up), `#N/A`... → `ErrorCell`, testo → `StringCell`
     * passato da `DataType::checkString` (max 32767 caratteri, `\r\n`/`\r` → `\n`).
     */
    public static function make(mixed $value, ?Style $style = null): Cell
    {
        if (! \is_string($value)) {
            return Cell::fromValue(\is_scalar($value) ? $value : null, $style);
        }

        $value = StringHelper::sanitizeUTF8($value);

        if ($value === '') {
            return new EmptyCell($value, $style);
        }

        return match (DefaultValueBinder::dataTypeForValue($value)) {
            DataType::TYPE_NUMERIC => new NumericCell(self::numericValue($value), $style),
            DataType::TYPE_FORMULA => new FormulaCell($value, $style, null),
            DataType::TYPE_ERROR => new ErrorCell($value, $style),
            default => new StringCell(self::stringValue($value), $style),
        };
    }

    /**
     * `0 + $value` di PhpSpreadsheet: int per le intere in range, float con `.`,
     * esponente o oltre int64 (`(int)` saturerebbe a PHP_INT_MAX).
     */
    private static function numericValue(string $value): int|float
    {
        Assert::numeric($value);

        return 0 + $value;
    }

    /**
     * `DataType::checkString` di PhpSpreadsheet: tronca a 32767 caratteri (OpenSpout
     * altrimenti lancia e il job muore) e normalizza i fine riga.
     */
    private static function stringValue(string $value): string
    {
        $checked = DataType::checkString($value);

        return \is_string($checked) ? $checked : $value;
    }
}
