<?php

declare(strict_types=1);

use Carbon\Carbon;
use Modules\Performance\Actions\GetHaDirittoMotivoAction;
use Modules\Performance\Models\BaseIndividualeModel;
use Modules\Performance\Models\Individuale;

function makeScheda(array $attributes = []): BaseIndividualeModel
{
    $scheda = new Individuale;

    $defaults = [
        'anno' => 2025,
        'gg_ruolo' => 250,
    ];

    foreach (array_merge($defaults, $attributes) as $key => $value) {
        $scheda->{$key} = $value;
    }

    return $scheda;
}

beforeEach(function () {
    $this->action = new GetHaDirittoMotivoAction;
    $this->action->year = 2025;
});

it('returns eligible when no exclusion criteria are provided', function () {
    $result = $this->action->execute(makeScheda(), [], []);

    expect($result)->toBe([1, '']);
});

it('throws exception for non string criterion key', function () {
    $this->action->execute(makeScheda(), [0 => 10], []);
})->throws(Exception::class, 'Chiave criterio non valida.');

it('ignores unknown criterion methods', function () {
    $result = $this->action->execute(makeScheda(), ['unknown_criterion' => 123], []);

    expect($result)->toBe([1, '']);
});

it('adds reason and denies eligibility when min_gg_ruolo fails', function () {
    $result = $this->action->execute(
        makeScheda(['gg_ruolo' => 99]),
        ['min_gg_ruolo' => 100],
        []
    );

    expect($result[0])->toBe(0)
        ->and($result[1])->toContain('no min gg_ruolo [99]');
});

it('checkMinGgRuolo validates threshold', function () {
    $message = $this->action->checkMinGgRuolo(['min_gg_ruolo' => 100], (object) ['gg_ruolo' => 90]);

    expect($message)->toBe('no min gg_ruolo [90]');
});

it('checkMinGgAnno validates effective days', function () {
    $message = $this->action->checkMinGgAnno(
        ['min_gg_anno' => 100],
        (object) ['gg_presenza_anno' => 120, 'gg_assenza_anno' => 30]
    );

    expect($message)->toBe('no min gg_anno [90]');
});

it('checkNoposizList validates excluded values', function () {
    $message = $this->action->checkNoposizList(['noposiz_list' => '10,20,30'], (object) ['posiz' => 20]);

    expect($message)->toBe('no_posiz [20]');
});

it('checkNoproproList validates excluded values', function () {
    $message = $this->action->checkNoproproList(['nopropro_list' => '1,2,3'], (object) ['propro' => 2]);

    expect($message)->toBe('no_propro [2]');
});

it('checkNoposfunList validates excluded values', function () {
    $message = $this->action->checkNoposfunList(['noposfun_list' => '5,6,7'], (object) ['posfun' => 6]);

    expect($message)->toBe('no_posfun [6]');
});

it('checkNodisci1List validates excluded values', function () {
    $message = $this->action->checkNodisci1List(['nodisci1_list' => '1,2,3'], (object) ['disci1' => 2]);

    expect($message)->toBe('no_disci1 [2]');
});

it('checkMaxGgAssenzeAnno validates max absence threshold', function () {
    $message = $this->action->checkMaxGgAssenzeAnno(['max_gg_assenze_anno' => 30], (object) ['gg_assenza_anno' => 35]);

    expect($message)->toBe('max gg assenze anno [35]>[30]');
});

it('checkDateMinAssunz validates minimum hiring date', function () {
    $message = $this->action->checkDateMinAssunz(
        ['date_min_assunz' => '2023-01-01'],
        (object) ['last_data_assunz' => '2024-01-01']
    );

    expect($message)->toBe('date min assunz [2024-01-01]>[2023-01-01][1]');
});

it('checkDateMinAssunz supports Carbon values', function () {
    $message = $this->action->checkDateMinAssunz(
        ['date_min_assunz' => Carbon::parse('2023-01-01')],
        (object) ['last_data_assunz' => Carbon::parse('2022-01-01')]
    );

    expect($message)->toBe('');
});

it('checkDateMinAssunz returns empty when last_data_assunz is null', function () {
    $message = $this->action->checkDateMinAssunz(
        ['date_min_assunz' => '2023-01-01'],
        (object) ['last_data_assunz' => null]
    );

    expect($message)->toBe('');
});

it('throws when required method parameter is missing', function () {
    $this->action->checkMinGgRuolo([], (object) ['gg_ruolo' => 10]);
})->throws(Exception::class, 'min_gg_ruolo is not defined');

it('supports historical alias for max absence check', function () {
    $message = $this->action->checkMaxGgAssenzaAnno(
        ['max_gg_assenze_anno' => 10],
        (object) ['gg_assenza_anno' => 11]
    );

    expect($message)->toBe('max gg assenze anno [11]>[10]');
});
