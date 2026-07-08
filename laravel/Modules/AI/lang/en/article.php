<?php

declare(strict_types=1);

// use Illuminate\Support\Facades\Auth;
// use Modules\Blog\Models\Profile;
// use Webmozart\Assert\Assert;

// Assert::notNull($user = Auth::user(), '['.__LINE__.']['.__FILE__.']');
// Assert::notNull($profile = $user->profile, '['.__LINE__.']['.__FILE__.']');
// Assert::isInstanceOf($profile, Profile::class);

return [
    'navigation' => [
        'name' => 'Article',
        'plural' => 'Articles',
        'group' => [
            'name' => 'Content',
        ],
    ],

    'rating' => [
        'no_import' => 'No digits entered',
        'import_zero' => 'No digits entered',
        'import_min' => 'You have exceeded the amount of :credits: credits',
        'no_choice' => 'No option chosen',
    ],
    'single_expired' => 'Expired',
    'expired' => 'Item has expired, no more bets can be placed',
    'no_vote' => 'Sorry, but this vote has been closed by :TIME, please try making another prediction',
    'your_bet' => 'Your prediction',
    'your_amount' => 'Prediction',
    'if_win' => 'If you win',
    'sell' => 'Sell',
    'time_left' => 'Time left: :days days, :hours hours, :minutes minutes',
    // 'fields' => [
    //     'name' => 'Nome',
    //     'guard_name' => 'Guard',
    //     'permissions' => 'Permessi',
    //     'roles' => 'Ruoli',
    //     'updated_at' => 'Aggiornato il',
    //     'first_name' => 'Nome',
    //     'last_name' => 'Cognome',
    // ],
    // 'actions' => [
    //     'import' => [
    //         'fields' => [
    //             'import_file' => 'Seleziona un file XLS o CSV da caricare',
    //         ],
    //     ],
    //     'export' => [
    //         'filename_prefix' => 'Aree al',
    //         'columns' => [
    //             'name' => 'Nome area',
    //             'parent_name' => 'Nome area livello superiore',
    //         ],
    //     ],
    // ],
];
