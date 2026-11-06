<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Xot\Actions\Config\ResolveModuleConfigDataAction;
use Modules\Xot\Filament\Traits\NavigationLabelTrait;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * Pagina impostazioni di un modulo: modifica `config/{tenant}/{modulo}.php`. Solo super-admin.
 *
 * Il modulo scrive solo il form:
 *
 *     class SettingPage extends BaseSettingPage
 *     {
 *         protected function getFormSchema(): array { return ['anni' => TagsInput::make('anni')]; }
 *     }
 *
 * Per convenzione legge e salva tramite `Modules\{Modulo}\Datas\{Modulo}ConfigData`, che tiene
 * default, tipi e normalizzazione. Chi non segue la convenzione sovrascrive
 * `getConfigName()` o `getConfigDataClass()`.
 *
 * Si legge il file del tenant, non `config()`: con `config:cache` attivo un salvataggio non
 * sarebbe visibile fino al prossimo `config:cache`.
 *
 * @see laravel/Modules/Xot/docs/stories/base-setting-page.story.md
 *
 * @property Schema $form
 */
abstract class BaseSettingPage extends XotBasePage
{
    use NavigationLabelTrait;
    use SuperAdminOnlyTrait;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    // URL uguale in ogni pannello: /{modulo}/admin/setting (default Filament: setting-page).
    protected static ?string $slug = 'setting';

    protected string $view = 'xot::filament.pages.base-setting';

    /**
     * Nome del file di configurazione, senza `.php`: `Progressioni` => `progressioni`.
     */
    public static function getConfigName(): string
    {
        return Str::lower(static::getModuleName());
    }

    /**
     * `Modules\{Modulo}\Datas\{Modulo}ConfigData`, stessa regola dei componenti condivisi
     * (ResolveModuleConfigDataAction).
     *
     * @return class-string<Data>
     */
    public static function getConfigDataClass(): string
    {
        $class = ResolveModuleConfigDataAction::dataClassFor(static::class);
        Assert::notNull($class, static::class.': manca la Data di configurazione Modules\\'.static::getModuleName().'\\Datas\\'.static::getModuleName().'ConfigData');

        return $class;
    }

    public function mount(): void
    {
        $this->form->fill($this->getConfigState());
    }

    public function form(Schema $schema): Schema
    {
        return $this->schema($schema);
    }

    /**
     * Every module has at least one operational setting; concrete pages add domain fields.
     *
     * @return array<string, object>
     */
    protected function getFormSchema(): array
    {
        return [
            'enabled' => Toggle::make('enabled')->default(true)->required(),
        ];
    }

    public function save(): void
    {
        /** @var array<string, mixed> $state */
        $state = $this->form->getState();
        $dataClass = static::getConfigDataClass();

        /** @var array<string, mixed> $data */
        $data = $dataClass::from($state)->toArray();
        app(SaveTenantConfigAction::class)->execute(static::getConfigName(), $data);

        // Ricarica dal file: il form mostra quello che e' stato davvero scritto (normalizzato e
        // fuso con le chiavi del file non gestite dal form).
        $this->form->fill($this->getConfigState());

        // Sidebar e topbar sono componenti Livewire separati: il salvataggio ridisegna solo la
        // pagina. Un'impostazione che cambia il menu (es. un WorkerType spento in Progressioni)
        // resterebbe visibile fino al cambio pagina. Eventi previsti da Filament per questo.
        $this->dispatch('refresh-sidebar');
        $this->dispatch('refresh-topbar');

        Notification::make()
            ->success()
            ->title(__('xot::base_setting.messages.saved'))
            ->send();
    }

    /**
     * Valori correnti del file del tenant, passati dalla Data (default e normalizzazione).
     *
     * @return array<string, mixed>
     */
    protected function getConfigState(): array
    {
        $dataClass = static::getConfigDataClass();
        $data = $dataClass::from(app(GetTenantConfigArrayAction::class)->execute(static::getConfigName()));

        $state = [];
        foreach ($data->toArray() as $key => $value) {
            $state[(string) $key] = $value;
        }

        return $state;
    }

    /**
     * Campo `anni` comune ai moduli con HasYearsConfig: anni di 4 cifre.
     */
    protected function anniField(): TagsInput
    {
        return TagsInput::make('anni')
            ->nestedRecursiveRules([
                'integer',
                'digits:4',
            ]);
    }

    /**
     * @return list<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')->submit('save'),
        ];
    }
}
