<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Illuminate\Support\Arr;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Performance\Filament\Resources\IndividualeDipResource\Pages;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Performance\Models\IndividualeDip;
use Modules\Xot\Actions\GetTransKeyAction;
use Override;

use function Safe\date;

class IndividualeDipResource extends IndividualeResource
{
    protected static ?string $model = IndividualeDip::class;

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndividualeDips::route('/'),
            'create' => Pages\CreateIndividualeDip::route('/create'),
            'edit' => Pages\EditIndividualeDip::route('/{record}/edit'),
            'fill_out_the_form' => Pages\FillOutTheForm::route('/{record}/fill'),
            'compila' => Pages\CompilaScheda::route('/{record}/compila'),
        ];
    }

    /**
     * @param array{stabi_repar_anno?: array{anno?: int|string}} $data
     * @return list<string|null>
     */
    #[Override]
    public static function getXlsFields(array $data): array
    {
        $anno = Arr::get($data, 'stabi_repar_anno.anno', intval(date('Y')) - 1);
        $criteri = CriteriValutazione::where('anno', $anno)
            ->where('post_type', 'dip')
            ->orderBy('posizione')
            ->get();

        $fields = [
            'id',
            'ente',
            'matr',
            'cognome',
            'nome',
            'email',
            'dal',
            'al',
        ];
        $transKey = app(GetTransKeyAction::class)->execute(static::class);
        $trans = trans($transKey);

        foreach ($criteri as $criterio) {
            $nome = $criterio->nome;
            if (! is_string($nome) || $nome === '') {
                continue;
            }

            $fields[] = $nome;
            Arr::set($trans, 'fields.'.$nome, $criterio->label);
        }
        app(SaveTransAction::class)->execute($transKey, $trans);
        $fields[] = 'excellence';
        $fields[] = 'totale_punteggio';

        return $fields;
    }
}
