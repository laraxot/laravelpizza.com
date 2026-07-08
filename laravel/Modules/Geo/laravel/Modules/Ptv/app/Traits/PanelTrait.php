<?php

declare(strict_types=1);

namespace Modules\Ptv\Traits;

// @phpstan-ignore trait.unused
trait PanelTrait
{
    public function lavoratoreFields(): array
    {
        // dddx(static::$model);//Modules\Performance\Models\IndividualeDip
        // dddx($this->row);
        $fields = [
            (object) [
                'type' => 'Integer',
                'name' => 'ente',
                'comment' => null,
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'matr',
                'comment' => null,
                'col_size' => 3,
            ],
            (object) [
                'type' => 'String',
                'name' => 'cognome',
                'comment' => null,
                'col_size' => 3,
            ],
            (object) [
                'type' => 'String',
                'name' => 'nome',
                'comment' => null,
                'col_size' => 3,
            ],
            /*
            (object)[
                 'type' => 'Integer',
                 'name' => 'ha_diritto',
                 'comment' => NULL,
                 'col_size' => 2,
            ],
            (object)[
                 'type' => 'Textarea',
                 'name' => 'motivo',
                 'comment' => NULL,
                 'col_size' => 3,
            ],
            */
            (object) [
                'type' => 'String',
                'name' => 'email',
                'comment' => null,
                'col_size' => 3,
            ],
        ];
        $fillable = $this->getFillable();

        if (\in_array('post_type', $fillable, false)) {
            $fields[] = (object) [
                'type' => 'String',
                'name' => 'post_type',
                'comment' => null,
                'col_size' => 3,
                'except' => ['edit', 'create'],
            ];
        }

        return $fields;
    }

    // end lavoratoreFields

    public function qua00Fields(): array
    {
        return [
            (object) [
                'type' => 'Integer',
                'name' => 'propro',
                'comment' => null,
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'posfun',
                'comment' => null,
                'col_size' => 3,
            ],

            (object) [
                'type' => 'String',
                'name' => 'posizione_eco',
                'comment' => null,
                'col_size' => 12,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'qua2kd',
                'comment' => null,
                'col_size' => 3,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'qua2ka',
                'comment' => null,
                'col_size' => 3,
            ],
        ];
    }

    // end qua00Fields

    public function stabiReparFields(): array
    {
        return [
            (object) [
                'type' => 'String',
                'name' => 'stabi',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'String',
                'name' => 'stabi_txt',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'String',
                'name' => 'repar',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'String',
                'name' => 'repar_txt',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'rep2kd',
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Integer',
                'name' => 'rep2ka',
                'col_size' => 6,
            ],
        ];
    }

    // end stabiReparFields

    public function ptimeFields(): array
    {
        return [
            (object) [
                'type' => 'Decimal',
                'name' => 'perc_parttime_anno',
                'comment' => null,
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Decimal',
                'name' => 'perc_parttime_dalal',
                'comment' => null,
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Decimal',
                'name' => 'gg_parttimevert_anno',
                'comment' => null,
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Decimal',
                'name' => 'gg_parttimevert_dalal',
                'comment' => null,
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Decimal',
                'name' => 'perc_parttimepond_anno',
                'comment' => null,
                'col_size' => 6,
            ],
            (object) [
                'type' => 'Decimal',
                'name' => 'perc_parttimepond_dalal',
                'comment' => null,
                'col_size' => 6,
            ],
        ];
    }

    public function haDirittoFields(): array
    {
        return [
            (object) [
                'type' => 'String',
                'name' => 'ha_diritto',
                'comment' => null,
            ],
            (object) [
                'type' => 'String',
                'name' => 'motivo',
                'comment' => null,
            ],
        ];
    }
}
