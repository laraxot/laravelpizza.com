---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
status: draft
---

# Blocchi di Contenuto

Questo documento contiene la documentazione dettagliata dei blocchi di contenuto.

## Struttura dei Blocchi

### Base Blocks
- `XotBaseTextBlock`: Blocco di testo con formattazione
- `XotBaseImageBlock`: Blocco immagine con caption
- `XotBaseGalleryBlock`: Galleria di immagini
- `XotBaseVideoBlock`: Video con player
- `XotBaseQuoteBlock`: Citazione con autore

### Layout Blocks
- `XotBaseColumnsBlock`: Colonne con contenuto
- `XotBaseAccordionBlock`: Accordion espandibile
- `XotBaseTabsBlock`: Tabs con contenuto
- `XotBaseCarouselBlock`: Carosello di elementi
- `XotBaseGridBlock`: Grid con items

### Special Blocks
- `XotBaseFormBlock`: Form con campi
- `XotBaseMapBlock`: Mappa con markers
- `XotBaseCalendarBlock`: Calendario eventi
- `XotBaseTableBlock`: Tabella dati
- `XotBaseChartBlock`: Grafico dati

## Implementazione

### Esempio Base
```php
namespace Modules\Cms\app\Models\Blocks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class XotBaseTextBlock extends Model
{
    protected $fillable = [
        'content',
        'format',
        'alignment',
        'style',
    ];

    protected $casts = [
        'content' => 'string',
        'format' => 'string',
        'alignment' => 'string',
        'style' => 'array',
    ];

    public function blockable(): MorphTo
    {
        return $this->morphTo();
    }
}
```

### Configurazione
```php
class TextBlockConfig
{
    public static function getConfig(): array
    {
        return [
            'name' => 'text',
            'label' => 'Testo',
            'icon' => 'heroicon-o-document-text',
            'component' => 'cms::blocks.text',
            'rules' => [
                'content' => ['required', 'string'],
                'format' => ['required', 'in:plain,html,markdown'],
                'alignment' => ['required', 'in:left,center,right'],
            ],
            'defaults' => [
                'format' => 'plain',
                'alignment' => 'left',
            ],
        ];
    }
}
```

### Rendering
```php
class TextBlockRenderer
{
    public function render(XotBaseTextBlock $block): string
    {
        return match($block->format) {
            'plain' => e($block->content),
            'html' => $block->content,
            'markdown' => Str::markdown($block->content),
        };
    }
}
```

## Gestione

### Versionamento
```php
class BlockVersion
{
    public function createVersion(Block $block): void
    {
        Version::create([
            'versionable_type' => $block->getMorphClass(),
            'versionable_id' => $block->id,
            'user_id' => auth()->id(),
            'content' => $block->toArray(),
        ]);
    }
}
```

### Cache
```php
class BlockCache
{
    public function remember(Block $block, Closure $callback): mixed
    {
        return Cache::tags(['blocks', $block->getMorphClass()])
            ->remember(
                "block:{$block->id}",
                now()->addHour(),
                $callback
            );
    }
}
```

## Frontend

### Componente Vue
```javascript
// resources/js/Blocks/TextBlock.vue
<template>
    <div class="text-block" :class="alignment">
        <div v-if="format === 'markdown'" v-html="renderedContent"></div>
        <div v-else>{{ content }}</div>
    </div>
</template>

<script>
export default {
    props: {
        content: String,
        format: String,
        alignment: String,
    },
    computed: {
        renderedContent() {
            return marked(this.content);
        },
    },
};
</script>
```

### Stili
```scss
.text-block {
    @apply prose max-w-none;

    &.left {
        @apply text-left;
    }

    &.center {
        @apply text-center;
    }

    &.right {
        @apply text-right;
    }
}
```

## API

### Endpoints
```php
Route::prefix('api/blocks')->group(function () {
    Route::get('/', [BlockController::class, 'index']);
    Route::post('/', [BlockController::class, 'store']);
    Route::get('/{block}', [BlockController::class, 'show']);
    Route::put('/{block}', [BlockController::class, 'update']);
    Route::delete('/{block}', [BlockController::class, 'destroy']);
});
```

### Resources
```php
class BlockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'content' => $this->content,
            'config' => $this->config,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
```

## Testing

### Unit Tests
```php
class TextBlockTest extends TestCase
{
    /** @test */
    public function it_renders_markdown(): void
    {
        $block = TextBlock::factory()->create([
            'content' => '# Test',
            'format' => 'markdown',
        ]);

        $this->assertStringContainsString(
            '<h1>Test</h1>',
            $block->render()
        );
    }
}
```

### Feature Tests
```php
class BlockApiTest extends TestCase
{
    /** @test */
    public function it_stores_a_block(): void
    {
        $response = $this->postJson('/api/blocks', [
            'type' => 'text',
            'content' => 'Test content',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('blocks', [
            'type' => 'text',
            'content' => 'Test content',
        ]);
    }
}
```

## File Contenuti

- `system.md`
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/readme.md)
* [README.md](bashscripts/docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/docs/readme.md)
* [README.md](laravel/modules/chart/docs/readme.md)
* [README.md](laravel/modules/reporting/docs/readme.md)
* [README.md](laravel/modules/gdpr/docs/phpstan/readme.md)
* [README.md](../../../Gdpr/docs/README.md)
* [README.md](../../../Notify/docs/phpstan/README.md)
* [README.md](../../../Notify/docs/README.md)
* [README.md](../../../Xot/docs/filament/README.md)
* [README.md](laravel/modules/xot/docs/phpstan/readme.md)
* [README.md](../../../Xot/docs/exceptions/readme.md)
* [README.md](../../../Xot/docs/README.md)
* [README.md](../../../Xot/docs/standards/README.md)
* [README.md](../../../Xot/docs/conventions/readme.md)
* [README.md](../../../Xot/docs/development/readme.md)
* [README.md](laravel/modules/dental/docs/readme.md)
* [README.md](laravel/modules/user/docs/phpstan/readme.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../User/resources/views/docs/README.md)
* [README.md](laravel/modules/ui/docs/phpstan/readme.md)
* [README.md](../../../UI/docs/README.md)
* [README.md](laravel/modules/ui/docs/standards/readme.md)
* [README.md](../../../UI/docs/themes/README.md)
* [README.md](../../../UI/docs/components/README.md)
* [README.md](laravel/modules/lang/docs/phpstan/readme.md)
* [README.md](../../../Lang/docs/README.md)
* [README.md](laravel/modules/job/docs/phpstan/readme.md)
* [README.md](../../../Job/docs/README.md)
* [README.md](laravel/modules/media/docs/phpstan/readme.md)
* [README.md](../../../Media/docs/README.md)
* [README.md](laravel/modules/tenant/docs/phpstan/readme.md)
* [README.md](../../../Tenant/docs/README.md)
* [README.md](laravel/modules/activity/docs/phpstan/readme.md)
* [README.md](../../../Activity/docs/README.md)
* [README.md](laravel/modules/patient/docs/readme.md)
* [README.md](laravel/modules/patient/docs/standards/readme.md)
* [README.md](laravel/modules/patient/docs/value-objects/readme.md)
* [README.md](laravel/modules/cms/docs/blocks/readme.md)
* [README.md](../README.md)
* [README.md](../standards/README.md)
* [README.md](../content/README.md)
* [README.md](../frontoffice/README.md)
* [README.md](../components/README.md)
* [README.md](laravel/themes/two/docs/readme.md)
* [README.md](laravel/themes/one/docs/readme.md)
