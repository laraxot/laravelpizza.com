<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Webmozart\Assert\Assert;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Widgets\TableWidget;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\AssociateAction;
use Filament\Actions\ReplicateAction;
use Modules\UI\Enums\TableLayoutEnum;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Enums\RecordActionsPosition;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Xot\Actions\Model\TableExistsByModelClassActions;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;

/**
 * Trait HasXotTable.
 *
 * Provides enhanced table functionality with translations and optimized structure.
 *
 * @property TableLayoutEnum $layoutView
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 */
trait HasXotForm
{
     /** @var array<string, mixed> */
    public array $data = [];

    abstract public function getFormSchema(): array;

    final public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->columns(2)
            ->statePath('data');
    }
}