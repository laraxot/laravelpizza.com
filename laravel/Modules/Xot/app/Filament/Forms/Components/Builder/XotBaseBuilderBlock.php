<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components\Builder;

use Filament\Forms\Components\Builder\Block as FilamentBuilderBlock;

/**
 * Base class for Builder\Block.
 *
 * Following Laraxot architectural pattern: never extend Filament classes directly.
 * This class wraps Filament's Builder\Block to provide a XotBase layer.
 *
 * Distinct from Modules\Xot\Filament\Blocks\XotBaseBlock, which follows a
 * different (static factory) pattern for CMS content blocks. Use this mirror
 * when a concrete class needs `extends Block` semantics, e.g. overriding
 * `make()`/`create()` while keeping the Filament\Forms\Components\Builder\Block API.
 */
abstract class XotBaseBuilderBlock extends FilamentBuilderBlock {}
