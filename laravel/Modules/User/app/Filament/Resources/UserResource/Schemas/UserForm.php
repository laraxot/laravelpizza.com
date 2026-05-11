<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Schemas;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Modules\User\Filament\Forms\Components\UserSection;
use Modules\User\Filament\Resources\UserResource\Pages\CreateUser;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class UserForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
    public static function getFormSchema(): array
    {
        return [
            'worker' => UserSection::make('worker'),
            'section01' => Section::make([
                'name' => TextInput::make('name')->required(),
                // 'email' => TextInput::make('email')->required()->unique(ignoreRecord: true),
                'password' => TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(function ($state): ?string {
                        // Type narrowing for PHPStan Level 10
                        if (! is_string($state) || empty($state)) {
                            return null;
                        }

                        return Hash::make($state);
                    })
                    ->required(fn ($livewire) => $livewire instanceof CreateUser),
            ])->columnSpan(8),
            'section02' => Section::make([
                'created_at' => Placeholder::make('created_at')->content(static function ($record) {
                    // Type narrowing for PHPStan Level 10
                    if (! $record instanceof Model) {
                        return new HtmlString('&mdash;');
                    }

                    // PHPStan Level 10: hasAttribute() invece di property_exists() per Eloquent
                    if (! $record->hasAttribute('created_at')) {
                        return new HtmlString('&mdash;');
                    }

                    /** @var Carbon|null $createdAt */
                    $createdAt = $record->getAttribute('created_at');

                    if (null === $createdAt) {
                        return new HtmlString('&mdash;');
                    }
                    if ($createdAt instanceof CarbonInterface) {
                        return $createdAt->diffForHumans();
                    }
                    if ($createdAt instanceof \DateTimeInterface) {
                        return $createdAt->format('Y-m-d H:i:s');
                    }

                    return new HtmlString('&mdash;');
                }),
            ])->columnSpan(4),
        ];
    }
}
