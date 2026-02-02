<?php

declare(strict_types=1);

/**
 * Database Configuration for laravelpizza tenant
 * 
 * IMPORTANTE: Le connessioni modulari sono gestite da TenantServiceProvider
 * Questo file eredita la configurazione standard da config/database.php
 * 
 * @see Modules/Tenant/docs/database-config-standard.md
 * @see Modules/Tenant/app/Providers/TenantServiceProvider.php
 */

return [
    // Configuration inherited from config/database.php
    // Modular connections (notify, geo, media, etc.) are registered
    // automatically by TenantServiceProvider::registerDB()
];
