<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Enums;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Enums\ProjectStatus;

uses(TestCase::class);

test('project status has correct labels', function (ProjectStatus $status, string $expectedLabel): void {
    expect($status->getLabel())->toBe($expectedLabel);
})->with([
    [ProjectStatus::Compilazione, 'Compilazione'],
    [ProjectStatus::Aggiudicazione, 'Aggiudicazione'],
    [ProjectStatus::Concluso, 'Concluso'],
    [ProjectStatus::Cancellato, 'Cancellato'],
]);

test('project status has correct colors', function (ProjectStatus $status, string $expectedColor): void {
    expect($status->getColor())->toBe($expectedColor);
})->with([
    [ProjectStatus::Compilazione, 'info'],
    [ProjectStatus::Aggiudicazione, 'warning'],
    [ProjectStatus::Concluso, 'success'],
    [ProjectStatus::Cancellato, 'danger'],
]);

test('project status has correct icons', function (ProjectStatus $status, string $expectedIcon): void {
    expect($status->getIcon())->toBe($expectedIcon);
})->with([
    [ProjectStatus::Compilazione, 'heroicon-m-pencil-square'],
    [ProjectStatus::Aggiudicazione, 'heroicon-m-star'],
    [ProjectStatus::Concluso, 'heroicon-m-check-badge'],
    [ProjectStatus::Cancellato, 'heroicon-m-x-circle'],
]);

test('project status can be cast from string', function (): void {
    $status = ProjectStatus::from('compilazione');
    expect($status)->toBe(ProjectStatus::Compilazione);
});

test('project status values match database values', function (): void {
    expect(ProjectStatus::Compilazione->value)->toBe('compilazione')
        ->and(ProjectStatus::Aggiudicazione->value)->toBe('aggiudicazione')
        ->and(ProjectStatus::Concluso->value)->toBe('concluso')
        ->and(ProjectStatus::Cancellato->value)->toBe('cancellato');
});
