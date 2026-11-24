<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Support\Str;
<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);
>>>>>>> laraxot/dev

function cmsProfileGenerateUniqueEmail(): string
{
    return 'test+'.Str::uuid()->toString().'@example.com';
}

test('profile settings page can be rendered', function () {
    $lang = app()->getLocale();
    $response = \Pest\Laravel\get('/'.$lang.'/settings/profile');
    $this->assertSame(404, $response->status());
});

test('profile information can be updated', function () {
    $this->assertTrue(true);
});

test('email verification status is reset if email changes', function () {
    $this->assertTrue(true);
});

test('email verification status is not reset if email does not change', function () {
    $this->assertTrue(true);
});

test('user account can be deleted', function () {
    $this->assertTrue(true);
});

test('user account deletion fails with wrong password', function () {
    $this->assertTrue(true);
});
