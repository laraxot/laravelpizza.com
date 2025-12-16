<?php

declare(strict_types=1);

return [
    'opening_hours' => [
        'morning' => 'Vormittag',
        'afternoon' => 'Nachmittag',
        'morning_before_afternoon' => 'Für :day muss die Vormittags-Schließzeit vor der Nachmittags-Öffnungszeit liegen.',
        'missing_closing_time' => 'Wenn Sie :session Öffnungszeit für :day angeben, müssen Sie auch die Schließzeit angeben.',
        'missing_opening_time' => 'Wenn Sie :session Schließzeit für :day angeben, müssen Sie auch die Öffnungszeit angeben.',
        'opening_before_closing' => 'Die :session Öffnungszeit für :day muss vor der Schließzeit liegen.',
    ],
];
