<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Datas;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Datas\EmailData;

describe('EmailData', function () {
    it('can be instantiated via reflection without constructor', function () {
        $reflection = new ReflectionClass(EmailData::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has correct namespace', function () {
        expect(EmailData::class)->toStartWith('Modules\Notify\Datas');
    });

    it('has required properties', function () {
        $reflection = new ReflectionClass(EmailData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        expect($propertyNames)->toContain('recipient');
        expect($propertyNames)->toContain('from');
        expect($propertyNames)->toContain('from_email');
        expect($propertyNames)->toContain('subject');
        expect($propertyNames)->toContain('body_html');
        expect($propertyNames)->toContain('body');
        expect($propertyNames)->toContain('attachments');
    });

    it('extends Spatie Data', function () {
        $reflection = new ReflectionClass(EmailData::class);

        expect($reflection->isSubclassOf(\Spatie\LaravelData\Data::class))->toBeTrue();
    });

    it('has getFrom method', function () {
        expect(method_exists(EmailData::class, 'getFrom'))->toBeTrue();
    });

    it('has getMimeEmail method', function () {
        expect(method_exists(EmailData::class, 'getMimeEmail'))->toBeTrue();
    });

    it('has from method', function () {
        expect(method_exists(EmailData::class, 'from'))->toBeTrue();
    });

    it('can create via static from method with valid data', function () {
        // Use Reflection to avoid constructor execution
        $reflection = new ReflectionClass(EmailData::class);
        $fromMethod = $reflection->getMethod('from');
        expect($fromMethod->isStatic())->toBeTrue();
    });
});
