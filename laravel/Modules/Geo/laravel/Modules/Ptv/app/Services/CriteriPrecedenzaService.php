<?php

declare(strict_types=1);

namespace Modules\Ptv\Services;

use Illuminate\Support\Facades\Request;
use Modules\Progressioni\Models\CriteriPrecedenza;

class CriteriPrecedenzaService
{
    /**
     * @return list<object{type: string, name: string|null, label: string|null}>
     */
    public static function getFieldsYear(int|string|null $year, bool $_is_po = false): array
    {
        if (is_null($year)) {
            $year = Request::input('year', 0);
        }

        $criteri = CriteriPrecedenza::where('anno', $year)
            // ->where('descr', $po_str)
            ->orderBy('posizione')
            ->get();

        $data = [];
        foreach ($criteri as $v) {
            $tmp = (object) [
                // 'type' => 'Decimal',
                'type' => 'String',
                'name' => $v->name,
                'label' => $v->label,
                // 'rules' => 'required|numeric|min:0|max:4',
            ];
            $data[] = $tmp;
        }

        return $data;
    }

    /**
     * Get field names for a specific year.
     *
     * @param  int  $year  The year to get fields for
     * @param  bool  $is_po  Whether to include PO-specific fields
     * @return array<int, string> Array of field names
     */
    public static function getFieldsNamesYear(int $year, bool $is_po = false): array
    {
        $fields = self::getFieldsYear($year, $is_po);
        $data = [];
        foreach ($fields as $field) {
            /** @var object{name: string, label: string, type: string} $field */
            $data[] = $field->name;
        }

        return $data;
    }
}
