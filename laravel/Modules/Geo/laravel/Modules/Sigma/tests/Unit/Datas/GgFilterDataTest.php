<?php

declare(strict_types=1);

namespace Modules\Sigma\Tests\Unit\Datas;

use Modules\Sigma\Datas\GgFilterData;
use Tests\TestCase;

/**
 * @covers \Modules\Sigma\Datas\GgFilterData
 */
class GgFilterDataTest extends TestCase
{
    public function test_from_accepts_lista_tipo_codice_as_array(): void
    {
        $data = GgFilterData::from([
            'lista_tipo_codice' => ['505-97', '506-12'],
            'lista_propro' => '714,704',
        ]);

        $this->assertSame('505-97,506-12', $data->lista_tipo_codice);
        $this->assertSame('714,704', $data->lista_propro);
    }

    public function test_from_accepts_lista_tipo_codice_as_string(): void
    {
        $data = GgFilterData::from([
            'lista_tipo_codice' => '505-97,506-12',
        ]);

        $this->assertSame('505-97,506-12', $data->lista_tipo_codice);
    }

    public function test_normalize_lista_tipo_codice_empty_array_returns_null(): void
    {
        $this->assertNull(GgFilterData::normalizeListaTipoCodice([]));
        $this->assertNull(GgFilterData::normalizeListaTipoCodice(''));
    }
}
