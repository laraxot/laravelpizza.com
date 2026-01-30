<?php

declare(strict_types=1);

namespace Modules\DbForge\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * AdminPanelProvider per il modulo DbForge.
 *
 * Questo provider gestisce la configurazione del pannello amministrativo Filament
 * per il modulo DbForge, che fornisce strumenti avanzati per la gestione
 * e manipolazione del database.
 *
 * Il modulo DbForge offre funzionalità per:
 * - Schema inspection e analisi database
 * - Table management (creazione, modifica, eliminazione)
 * - Index management per ottimizzazione
 * - Constraint management e relazioni
 * - Custom migrations e rollback
 * - Query builder avanzato
 * - Backup e restore automatizzati
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    /**
     * Nome del modulo.
     *
     * Questo valore viene utilizzato per:
     * - Generare il namespace corretto per le risorse Filament
     * - Configurare il path del pannello amministrativo
     * - Identificare il modulo nel sistema
     */
    protected string $module = 'DbForge';

    /**
     * Configurazione aggiuntiva del pannello.
     *
     * Override del metodo panel per aggiungere configurazioni specifiche
     * del modulo DbForge se necessario.
     */
    public function panel(Panel $panel): Panel
    {
        // Chiama il metodo parent per la configurazione base
        return parent::panel($panel);

        // Configurazioni specifiche per DbForge possono essere aggiunte qui
        // Ad esempio:
        // - Plugin specifici per database management
        // - Widget personalizzati per monitoring database
        // - Configurazioni di sicurezza aggiuntive
    }
}
