<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Gdpr\Filament\Resources\TreatmentResource\Tables;

use Filament\Tables\Columns\IconColumn;
=======
namespace Modules\base_quaeris_fila5\var\www\_bases\base_quaeris_fila5\laravel\Modules\Gdpr\app\Filament\Resources\TreatmentResource\Tables;

use Filament\Tables\Columns\Column;
>>>>>>> 40b96bcd6 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TreatmentsTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
    {
        return [
            'active' => IconColumn::make('active')->boolean(),
            'required' => IconColumn::make('required')->boolean(),
            'name' => TextColumn::make('name')->searchable(),
            'documentVersion' => TextColumn::make('documentVersion')->searchable(),
            'documentUrl' => TextColumn::make('documentUrl')->searchable(),
            'weight' => TextColumn::make('weight')->numeric()->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
=======
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        /*
         * @return array<int|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
