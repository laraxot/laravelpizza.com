<?php

declare(strict_types=1);

namespace Modules\Progressioni\Services;

use Modules\Progressioni\Models\CriteriValutazione;
use Request;

class CriteriValutazioneService
{
    /**
     * @return array<int, object{name: string|null, label: string|null, type: string}>
     */
    public static function getFieldsYear(int $_year, bool $_is_po = false): array
    {
        $year = Request::input('year', 0);
        if (is_string($year)) {
            $year = intval($year);
        }
        $criteri = CriteriValutazione::where('anno', $year)
            // ->where('descr', $po_str)
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
}
