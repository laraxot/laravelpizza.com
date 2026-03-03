<?php
namespace Modules\Xot\Tests\Feature\Filament;
use Modules\Xot\Filament\Resources\XotBaseResource;
class MockResourceWithRelations extends XotBaseResource {
 protected static ?string $model = \Modules\Xot\Models\Cache::class;
 public static function getFormSchema(): array { return []; }
}