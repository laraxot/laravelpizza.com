<?php

declare(strict_types=1);

use Illuminate\Console\Command;
use Modules\User\Console\Commands\ChangeTypeCommand;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;
use ReflectionNamedType;

uses(Modules\User\Tests\TestCase::class);

function changeTypeCommandInstance(): ChangeTypeCommand
{
    return new ChangeTypeCommand();
}

test('change type command can be instantiated', function (): void {
    $command = changeTypeCommandInstance();

    Assert::assertInstanceOf(ChangeTypeCommand::class, $command);
    Assert::assertInstanceOf(Command::class, $command);
});

test('change type command has correct name', function (): void {
    Assert::assertSame('user:change-type', changeTypeCommandInstance()->getName());
});

test('change type command has correct description', function (): void {
    Assert::assertSame(
        'Change user type based on project configuration',
        changeTypeCommandInstance()->getDescription(),
    );
});

test('change type command name property matches signature', function (): void {
    $command = changeTypeCommandInstance();
    $reflection = new ReflectionClass($command);
    $nameProperty = $reflection->getProperty('name');

    Assert::assertSame('user:change-type', $nameProperty->getValue($command));
});

test('change type command handle method is public void', function (): void {
    $reflection = new ReflectionClass(changeTypeCommandInstance());
    $handleMethod = $reflection->getMethod('handle');
    $returnType = $handleMethod->getReturnType();

    Assert::assertTrue($handleMethod->isPublic());
    Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
    Assert::assertSame('void', $returnType->getName());
});

test('change type command can access xot data dependency', function (): void {
    Assert::assertInstanceOf(XotData::class, XotData::make());
});

test('change type command extends laravel console command', function (): void {
    Assert::assertInstanceOf(Command::class, changeTypeCommandInstance());
});

test('change type command has protected name and description properties', function (): void {
    $reflection = new ReflectionClass(changeTypeCommandInstance());

    Assert::assertTrue($reflection->hasProperty('name'));
    Assert::assertTrue($reflection->hasProperty('description'));
    Assert::assertTrue($reflection->getProperty('name')->isProtected());
    Assert::assertTrue($reflection->getProperty('description')->isProtected());
});

test('change type command docblock documents purpose', function (): void {
    $docComment = (new ReflectionClass(ChangeTypeCommand::class))->getDocComment();

    Assert::assertIsString($docComment);
    Assert::assertStringContainsString('Command to change user type', $docComment);
});
