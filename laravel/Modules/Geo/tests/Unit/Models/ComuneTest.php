<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

/*
 * Specifica neutralizzata: i 16 scenari di questa prima stesura vivono ora in ComuneModelTest.php.
 *
 * Questo file era una classe PHPUnit che chiamava sul modello Comune i named scope byRegion(), byProvince(),
 * byCap(), byName(), byExactName() e le loro combinazioni. Quei metodi non esistono su Comune e non sono mai
 * esistiti: `git log --all -S'function byRegion' -- app/Models/Comune.php` e vuoto. Solo byRegion(), byProvince()
 * e byCap() esistono, come metodi statici di ComuneJson (che restituisce collection di array, non un builder).
 * I 69 commenti di ignore PHPStan della vecchia stesura coprivano proprio questo.
 *
 * Gli stessi comportamenti sono provati da ComuneModelTest.php con le API reali di Comune (query Eloquent,
 * findByCap(), findByNome()) e le letture del JSON da comunetest.php. Il corpo vecchio resta in git
 * (blob fafb1aa9 in HEAD, commit 60524329; blob 5e25f92a in laraxot/dev).
 */

describe('Comune query scopes (first draft)', function (): void {
    it('filters comuni by region, province, cap and name with the by*() scopes')
        ->skip('Comune::byRegion() and the other by*() scopes not implemented');

    it('loads, creates, updates and deletes a comune')
        ->skip('superseded by ComuneModelTest.php');
});
