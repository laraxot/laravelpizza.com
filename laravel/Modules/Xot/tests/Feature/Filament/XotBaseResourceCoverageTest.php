<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Filament;

use Filament\Schemas\Components\Wizard\Step;
use Illuminate\Support\HtmlString;
use Modules\Media\Actions\GetAttachmentsSchemaAction;
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Actions\ModelClass\CountAction;
use Modules\Xot\Filament\Resources\ProbeResource;
use Tests\TestCase;

require_once __DIR__.'/../../Fixtures/Models/Probe.php';
require_once __DIR__.'/../../Fixtures/Filament/Resources/ProbeResource.php';

uses(TestCase::class);

it('covers model resolution and model cache', function (): void {
    ProbeResource::resetModelCache();

    expect(ProbeResource::getModel())->toBe(\Modules\Xot\Models\Probe::class)
        ->and(ProbeResource::getModel())->toBe(\Modules\Xot\Models\Probe::class);
});

it('covers default relation discovery with missing relation manager classes', function (): void {
    expect(ProbeResource::getRelations())->toBe([]);
});

it('covers default page discovery including optional view page', function (): void {
    $pages = ProbeResource::getPages();

    expect($pages)->toHaveKeys(['index', 'create', 'edit', 'view']);
});

it('covers translation helper key normalization', function (): void {
    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'probe.cluster.pages.item_widget';
        }
    });

    expect(ProbeResource::callGetKeyTrans('title'))->toBe('probe.item_widget.title');
});

it('covers translation helper edit and widget normalization branches', function (): void {
    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'edit_';
        }
    });

    expect(ProbeResource::callGetKeyTrans('name'))->toBe('.name');

    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'probe';
        }
    });

    expect(ProbeResource::callGetKeyTrans('title_widget'))->toBe('probe.title');
});

it('covers translation helper string path and missing key fallback', function (): void {
    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'probe.messages';
        }
    });

    app('translator')->addLines(['probe.messages.ok' => 'Done'], app()->getLocale());

    expect(ProbeResource::trans('ok'))->toBe('Done')
        ->and(ProbeResource::trans('missing'))->toBe('probe.messages.missing');
});

it('covers translation helper array and fix fallback branches', function (): void {
    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'probe.arr';
        }
    });

    app('translator')->addLines([
        'probe.arr.scalar' => [123],
        'probe.arr.nonscalar' => [['x' => 1]],
    ], app()->getLocale());

    expect(ProbeResource::trans('scalar'))->toBe('123')
        ->and(ProbeResource::trans('nonscalar'))->toBe('fix:probe.arr.nonscalar');
});

it('covers translation helper exception branch', function (): void {
    app()->instance(GetTransKeyAction::class, new class {
        public function execute(string $class): string
        {
            return 'probe.exceptions';
        }
    });

    ProbeResource::trans('missing', true);
})->throws(\Exception::class);

it('covers navigation badge success and fallback', function (): void {
    app()->instance(CountAction::class, new class {
        public function execute(string $class): int
        {
            return 42;
        }
    });

    expect(ProbeResource::getNavigationBadge())->toBe('42');

    app()->instance(CountAction::class, new class {
        public function execute(string $class): int
        {
            throw new \Exception('boom');
        }
    });

    expect(ProbeResource::getNavigationBadge())->toBe('--');
});

it('covers get attachments schema branches', function (): void {
    $resourceNoAttachments = new class extends \Modules\Xot\Filament\Resources\XotBaseResource {
        protected static ?string $model = \Modules\Xot\Models\Probe::class;

        public static function getFormSchema(): array
        {
            return [];
        }
    };

    expect($resourceNoAttachments::getAttachmentsSchema())->toBe([]);

    if (! class_exists('Modules\\Xot\\Models\\ProbeBadAttachments')) {
        eval('namespace Modules\\Xot\\Models; class ProbeBadAttachments extends \\Illuminate\\Database\\Eloquent\\Model { public static function getAttachments(): string { return "invalid"; } }');
    }

    $resourceBadAttachments = new class extends \Modules\Xot\Filament\Resources\XotBaseResource {
        protected static ?string $model = \Modules\Xot\Models\ProbeBadAttachments::class;

        public static function getFormSchema(): array
        {
            return [];
        }
    };

    expect($resourceBadAttachments::getAttachmentsSchema())->toBe([]);

    if (! class_exists('Modules\\Xot\\Models\\ProbeGoodAttachments')) {
        eval('namespace Modules\\Xot\\Models; class ProbeGoodAttachments extends \\Illuminate\\Database\\Eloquent\\Model { public static function getAttachments(): array { return ["one", 7, "two"]; } }');
    }

    app()->instance(GetAttachmentsSchemaAction::class, new class {
        public function execute(array $attachments, string $disk): array
        {
            if ($attachments !== ['one', 'two'] || 'attachments' !== $disk) {
                throw new \RuntimeException('unexpected attachments payload');
            }

            return ['schema'];
        }
    });

    $resourceGoodAttachments = new class extends \Modules\Xot\Filament\Resources\XotBaseResource {
        protected static ?string $model = \Modules\Xot\Models\ProbeGoodAttachments::class;

        public static function getFormSchema(): array
        {
            return [];
        }
    };

    expect($resourceGoodAttachments::getAttachmentsSchema())->toBe(['schema']);
});

it('covers wizard submit action success and failure paths', function (): void {
    expect(fn () => ProbeResource::getWizardSubmitAction())->toThrow(\Exception::class);

    $tmpViewDir = sys_get_temp_dir().'/xot-resource-view-'.uniqid('', true);
    $viewPath = $tmpViewDir.'/filament/wizard';
    mkdir($viewPath, 0777, true);
    file_put_contents($viewPath.'/submit-button.blade.php', '<button>submit</button>');

    view()->addNamespace('pub_theme', $tmpViewDir);

    $html = ProbeResource::getWizardSubmitAction();
    expect($html)->toBeInstanceOf(HtmlString::class)
        ->and($html->toHtml())->toContain('submit');
});

it('covers step builder branches', function (): void {
    expect(ProbeResource::callGetStepByName('custom_step'))->toBeInstanceOf(Step::class)
        ->and(ProbeResource::callGetStepByName('missing_step'))->toBeInstanceOf(Step::class);
});

it('covers simple base helpers', function (): void {
    $resource = new ProbeResource();

    expect(ProbeResource::getModuleName())->toBe('Xot')
        ->and($resource->hasCombinedRelationManagerTabsWithContent())->toBeTrue()
        ->and(ProbeResource::getFormSchemaColumns())->toBe(1)
        ->and(ProbeResource::getInfolistSchema())->toBe([])
        ->and(ProbeResource::extendTableCallback())->toBe([])
        ->and(ProbeResource::extendFormCallback())->toBe([]);
});
