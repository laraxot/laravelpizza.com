<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

/**
 * Resource for IndennitaResponsabilita management.
 */
class IndennitaResponsabilitaResource extends XotBaseResource
{
    protected static ?string $model = IndennitaResponsabilita::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndennitaResponsabilitas::route('/'),
            'create' => Pages\CreateIndennitaResponsabilita::route('/create'),
            'edit' => Pages\EditIndennitaResponsabilita::route('/{record}/edit'),
            'view' => Pages\ViewIndennitaResponsabilita::route('/{record}'),
            'compila' => Pages\CompilaIndennitaResponsabilita::route('/{record}/compila'),
            'log-activity' => Pages\ListSchedaLogActivities::route('/{record}/log-activity'),
        ];
    }

    public static function getFormSchema(): array
    {
        return [
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public static function getTableSchema(): array
    {
        return [
        ];
    }

    /**
     * @return array<int, \Filament\Actions\Action>
     */
    public static function getActions(): array
    {
        return [
            Action::make('downloadXls')
                ->label(__('Download XLS'))
                ->icon('heroicon-o-arrow-down-tray')
                // @phpstan-ignore argument.type (Filament passes form data as array)
                ->action(fn (array $data) => static::downloadXlsAction($data))
                ->visible(fn (): bool => static::canDownloadXls()),
        ];
    }

    public static function canDownloadXls(): bool
    {
        return Gate::allows('downloadXls', Auth::user());
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function downloadXlsAction(array $data): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // TODO: Implement Excel file generation logic
        throw new \RuntimeException('downloadXlsAction not yet implemented');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<int, string>
     */
    public static function getXlsFields(array $data): array
    {
        $anno = Arr::get($data, 'anno/valutatore.anno', null);
        if ($anno == null) {
            return [];
        }
        // $ratings=Rating::withExtraAttributes(['anno' => $anno])->get();

        return [
            'matr',
            'cognome',
            'nome',
            'email', /*
            'valutatore_id',
            'ratings.3',
            'ratings.3.value',
            'ratings.3.pivot.value',
            */
        ];
    }
}
