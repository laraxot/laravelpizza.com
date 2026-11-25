<?php

declare(strict_types=1);

/*
 * FILE NON LETTO DA NESSUNA CHIAVE. Le etichette qui sotto sono indicizzate per nome
 * del caso (`ZeroFive`), mentre `Modules\Xot\Traits\EnumTrait` costruisce
 * `rating::rule_enum.values.<VALORE>.<attributo>` — cioe' gruppo `rule_enum`, chiave uguale
 * al valore del caso (`numeric|min:0|max:5`). Il gruppo `enums` non compare in nessuna chiave.
 *
 * Le etichette sono state trasferite in `rule_enum.php`, dove vengono effettivamente
 * risolte. Questo file resta per non perdere la traccia di chi le aveva scritte: prima di
 * modificarlo, verificare che serva ancora a qualcuno.
 */

return [
    'ZeroFive' => [
        'label' => 'da 0 a 5',
    ],
    'Null' => [
        'label' => 'nessuna regola',
    ],
    'ZeroOrMin4Max25' => [
        'label' => 'o Zero o da 4 a 25',
    ],
];
