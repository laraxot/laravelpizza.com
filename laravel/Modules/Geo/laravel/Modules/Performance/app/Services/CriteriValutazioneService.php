<?php

declare(strict_types=1);

namespace Modules\Performance\Services;

use Modules\Performance\Models\CriteriValutazione;
use Request;

class CriteriValutazioneService
{
    /**
     * Undocumented function.
     *
     * @return array<int, object>
     */
    public static function getFieldsYear(int $_year, bool $is_po = false): array
    {
        $year = (int) Request::input('year');
        $po_str = $is_po ? 'PO' : '';
        $criteri = CriteriValutazione::where('anno', $year)
            ->where('descr', $po_str)
            ->get();

        $data = [];
        foreach ($criteri as $v) {
            $tmp = (object) [
                'type' => 'Decimal',
                'name' => $v->nome,
                'label' => $v->label,
                'rules' => 'required|numeric|min:0|max:4',
            ];
            $data[] = $tmp;
        }

        return $data;
    }

    /**
     * @return array<int, object>
     */
    public static function getFieldsYearPostType(int $year, string $post_type): array
    {
        // $year = (int)\Request::input('year');

        $criteri = CriteriValutazione::where('anno', $year)
            ->where('post_type', $post_type)
            ->get();

        $data = [];
        foreach ($criteri as $v) {
            $tmp = (object) [
                'type' => 'Decimal',
                'name' => $v->nome,
                'label' => $v->label,
                'rules' => 'required|numeric|min:0|max:4',
            ];
            $data[] = $tmp;
        }

        return $data;
    }
}
