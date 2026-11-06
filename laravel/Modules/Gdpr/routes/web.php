<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Gdpr\Actions\Account\DeleteAccountAction;

// Deregistrazione (DCP-164): GET per la vista, POST per l'azione.
// Non cancella fisicamente: Soft Deletes + revoca consensi + audit trail.
// Route caricata da XotBaseRouteServiceProvider (namespace Modules\Gdpr).
Route::match(['get', 'post'], '/{lang}/account/delete', [DeleteAccountAction::class, '__invoke'])
    ->where('lang', '[a-z]{2}')
    ->middleware('auth')
    ->name('account.delete');