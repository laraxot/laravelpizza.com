<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Datas;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Datas\EmailAttachmentData;

describe('EmailAttachmentData', function () {
    it('can be referenced via reflection without instantiation', function () {
        $reflection = new ReflectionClass(EmailAttachmentData::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has correct namespace', function () {
        expect(EmailAttachmentData::class)->toStartWith('Modules\Notify\Datas');
    });

    it('extends Spatie Data', function () {
        $reflection = new ReflectionClass(EmailAttachmentData::class);

        expect($reflection->isSubclassOf(\Spatie\LaravelData\Data::class))->toBeTrue();
    });

    it('has required properties', function () {
        $reflection = new ReflectionClass(EmailAttachmentData::class);
        $properties = $reflection->getProperties();

        $propertyNames = array_map(fn ($p) => $p->getName(), $properties);

        expect($propertyNames)->toContain('name');
        expect($propertyNames)->toContain('contentType');
    });

    it('has getContent method', function () {
        expect(method_exists(EmailAttachmentData::class, 'getContent'))->toBeTrue();
    });

    it('has constructor with required parameters', function () {
        $reflection = new ReflectionClass(EmailAttachmentData::class);
        $constructor = $reflection->getConstructor();

        expect($constructor)->not->toBeNull();

        $params = $constructor->getParameters();
        expect($params)->toHaveCount(3);
    });
});
