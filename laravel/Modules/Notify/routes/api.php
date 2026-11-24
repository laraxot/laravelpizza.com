<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Notify\Actions\Mail\Mailjet\HandleMailjetEventsAction;
use Modules\Notify\Actions\Mail\ProcessInboundMailAction;

/*--work in progress
 * use Modules\Notify\Http\Controllers\TelegramNotificationController;
 *
 * Route::middleware('guest')->group(function () {
 * Route::post('/telegram/webhook/',
 * [TelegramNotificationController::class, 'store'])->middleware('api');
 *
 * Route::get('/telegram/webhook/',
 * [TelegramNotificationController::class, 'view'])->middleware('api');
 * });
 */

Route::post('/inbound/{provider}/{token}', [ProcessInboundMailAction::class, '__invoke'])
    ->name('notify.inbound');

// Esiti delle email da Mailjet (consegnata, rimbalzata, spam, ...). Docs: Modules/Notify/docs/email/mailjet.md
Route::post('/notify/mailjet/events/{token}', [HandleMailjetEventsAction::class, '__invoke'])
    ->name('notify.mailjet.events');
