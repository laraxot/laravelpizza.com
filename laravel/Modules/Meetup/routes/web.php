<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Meetup\Actions\Assistant\RunMeetupAssistantAction;

/*
 * Assistente AI nel sito (story 7-5): endpoint AG-UI in streaming per la chat. Non è una pagina (le pagine sono Folio):
 * riceve i messaggi della chat dell'utente collegato. Docs: Modules/Meetup/docs/assistant.md
 */
// Barra iniziale: il gruppo delle rotte del modulo antepone il namespace dei controller.
Route::post('/meetup/assistant', '\\'.RunMeetupAssistantAction::class)
    ->middleware(['web', 'auth', 'throttle:20,1'])
    ->name('meetup.assistant');
