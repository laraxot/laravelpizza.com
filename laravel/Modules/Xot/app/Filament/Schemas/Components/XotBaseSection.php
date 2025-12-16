<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Schemas\Components;

use Filament\Schemas\Components\Section;

/**
 * Base class for custom Section components following Laraxot philosophy.
 *
 * In the Laraxot framework, all custom Section components should extend
 * XotBaseSection instead of directly extending Filament\Schemas\Components\Section.
 * This ensures consistency with the framework's architecture and provides
 * a foundation for common Section functionality across the application.
 *
 * @method static static make(string|array|null $name = null) Create a new instance of the component
 */
    abstract class XotBaseSection extends Section
    {
        protected function setUp(): void
        {
            parent::setUp();
            // Common setup for all XotBaseSection components can be added here.
            // NOTE: do not call non-existent macros like disableLiveUpdates() to
            // avoid BadMethodCallException at runtime.
        }

        /**
         * Provide a dummy implementation for disableLiveUpdates() to prevent BadMethodCallException.
         * This method existed in older Filament versions but is no longer present in v4 Section.
         */
        public function disableLiveUpdates(): static
        {
            return $this;
        }
    }