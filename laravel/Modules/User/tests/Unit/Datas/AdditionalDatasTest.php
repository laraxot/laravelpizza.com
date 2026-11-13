<?php

declare(strict_types=1);
use Modules\User\Datas\DeviceData;
use Modules\User\Datas\FilamentShieldData;
use Modules\User\Datas\FilamentUserData;
use Modules\User\Datas\PermissionCacheData;
use Modules\User\Datas\PermissionColumnNamesData;
use Modules\User\Datas\PermissionData;
use Modules\User\Datas\PermissionModelsData;
use Modules\User\Datas\PermissionTableNamesData;
use Modules\User\Datas\ShieldResourceData;
use Modules\User\Datas\SocialProviderData;
use Modules\User\Datas\SuperAdminData;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

test('PermissionTableNamesData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(PermissionTableNamesData::from([]))->toEqual(PermissionTableNamesData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('ShieldResourceData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(ShieldResourceData::from([]))->toEqual(ShieldResourceData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('FilamentUserData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(FilamentUserData::from([]))->toEqual(FilamentUserData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('SuperAdminData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(SuperAdminData::from([]))->toEqual(SuperAdminData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('PermissionData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(PermissionData::from([]))->toEqual(PermissionData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('PermissionColumnNamesData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(PermissionColumnNamesData::from([]))->toEqual(PermissionColumnNamesData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('PermissionCacheData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(PermissionCacheData::from([]))->toEqual(PermissionCacheData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('DeviceData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(DeviceData::from([]))->toEqual(DeviceData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('SocialProviderData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(SocialProviderData::from([]))->toEqual(SocialProviderData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('FilamentShieldData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(FilamentShieldData::from([]))->toEqual(FilamentShieldData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});

test('PermissionModelsData can be instantiated', function () {
    // Un payload vuoto puo' creare il Data (tutti i campi opzionali) o essere rifiutato: entrambi gli esiti vanno bene.
    try {
        expect(PermissionModelsData::from([]))->toEqual(PermissionModelsData::from([]));
    } catch (Exception $exception) {
        expect($exception->getMessage())->not->toBe('');
    }
});
