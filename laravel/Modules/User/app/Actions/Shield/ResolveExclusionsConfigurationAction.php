<?php

declare(strict_types=1);

namespace Modules\User\Actions\Shield;

use Spatie\QueueableAction\QueueableAction;

/**
 * Action per risolvere la configurazione di exclusioni.
 *
 * Raggruppa: isGeneralExcludeEnabled, enableGeneralExclude, disableGeneralExclude,
 * getExcludedResources, getExcludedPages, getExcludedWidgets
 */
class ResolveExclusionsConfigurationAction
{
    use QueueableAction;

    /**
     * Execute the action to resolve exclusions configuration.
     *
     * @return array{
     *     general_exclude_enabled: bool,
     *     excluded_resources: list<string>,
     *     excluded_pages: list<string>,
     *     excluded_widgets: list<string>,
     * }
     */
    public function execute(): array
    {
        return [
            'general_exclude_enabled' => $this->isGeneralExcludeEnabled(),
            'excluded_resources' => $this->getExcludedResources(),
            'excluded_pages' => $this->getExcludedPages(),
            'excluded_widgets' => $this->getExcludedWidgets(),
        ];
    }

    private function isGeneralExcludeEnabled(): bool
    {
        $res = config('filament-shield.exclude.enabled', true);

        return is_bool($res) ? $res : true;
    }

    public function enableGeneralExclude(): void
    {
        config(['filament-shield.exclude.enabled' => true]);
    }

    public function disableGeneralExclude(): void
    {
        config(['filament-shield.exclude.enabled' => false]);
    }

    /**
     * @return list<string>
     */
    private function getExcludedResources(): array
    {
        $res = config('filament-shield.exclude.resources', []);

        if (! is_array($res)) {
            return [];
        }

        return array_values(array_filter($res, is_string(...)));
    }

    /**
     * @return list<string>
     */
    private function getExcludedPages(): array
    {
        $res = config('filament-shield.exclude.pages', []);

        if (! is_array($res)) {
            return [];
        }

        return array_values(array_filter($res, is_string(...)));
    }

    /**
     * @return list<string>
     */
    private function getExcludedWidgets(): array
    {
        $res = config('filament-shield.exclude.widgets', []);

        if (! is_array($res)) {
            return [];
        }

        return array_values(array_filter($res, is_string(...)));
    }
}
