<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

/**
 * Service provider for the IndennitaCondizioniLavoro module.
 *
 * Tutte le registrazioni standard (views, translations, migrations, SVG, asset, ecc.)
 * sono già gestite da XotBaseServiceProvider.
 * Qui si aggiungono solo personalizzazioni specifiche del modulo (se necessarie).
 *
 * Proprietà fondamentali per XotBaseServiceProvider:
 * - $module_dir: directory del modulo
 * - $module_ns: namespace del modulo
 * - $name: nome del modulo
 */
class IndennitaCondizioniLavoroServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    public string $name = 'IndennitaCondizioniLavoro';
    // Nessun metodo aggiuntivo: tutto è gestito dal base provider.
}
