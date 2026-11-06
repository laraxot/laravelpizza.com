<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as ModuleData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Moduli abilitati che possono essere il modulo principale: quelli con un pannello Filament.
 *
 * `XotBasePanelProvider` rende predefinito il pannello del modulo principale: indicarne uno senza pannello
 * lascerebbe il sito senza pannello predefinito, per questo la SettingPage offre solo questi.
 */
final class ListMainModuleCandidatesAction
{
    use QueueableAction;

    private const string PANEL_PROVIDER = '/app/Providers/Filament/AdminPanelProvider.php';

    /**
     * @return array<string, string> nome => nome
     */
    public function execute(): array
    {
        $names = [];
        foreach (Module::allEnabled() as $module) {
            if (! $module instanceof ModuleData) {
                continue;
            }

            $name = $module->getName();
            Assert::string($name);

            if (is_file($module->getPath().self::PANEL_PROVIDER)) {
                $names[$name] = $name;
            }
        }
        ksort($names);

        return $names;
    }
}
