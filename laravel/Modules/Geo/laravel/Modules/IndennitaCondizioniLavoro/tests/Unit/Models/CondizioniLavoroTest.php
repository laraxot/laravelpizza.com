<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use PHPUnit\Framework\Assert;

function makeCondizioniLavoroForTest(): CondizioniLavoro
{
    return new CondizioniLavoro([
        'ente' => 90,
        'matr' => 12345,
        'anno' => 2026,
        'quadrimestre' => 2,
        'stabi' => 10,
        'repar' => 20,
        'valutatore_id' => 50,
    ]);
}

describe('CondizioniLavoro model', function (): void {
    it('uses the expected table and key', function (): void {
        $model = makeCondizioniLavoroForTest();

        Assert::assertSame('condizioni_lavoro', $model->getTable());
        Assert::assertSame('id', $model->getKeyName());
        Assert::assertTrue($model->getIncrementing());
    });

    it('exposes canonical date and identity fields', function (): void {
        $model = makeCondizioniLavoroForTest();

        Assert::assertSame('dal', $model->rangeFromField());
        Assert::assertSame('al', $model->rangeToField());
        Assert::assertSame('anno', $model->annFieldName());
        Assert::assertSame('matr', $model->matrField());
        Assert::assertSame('ente', $model->enteField());
        Assert::assertSame('anno', $model->yearField());
    });

    it('keeps fillable work condition attributes', function (): void {
        $fillable = makeCondizioniLavoroForTest()->getFillable();

        Assert::assertContains('ente', $fillable);
        Assert::assertContains('matr', $fillable);
        Assert::assertContains('anno', $fillable);
        Assert::assertContains('quadrimestre', $fillable);
        Assert::assertContains('valutatore_id', $fillable);
    });

    it('casts date attributes as datetime', function (): void {
        $casts = makeCondizioniLavoroForTest()->getCasts();

        Assert::assertSame('datetime', $casts['dal']);
        Assert::assertSame('datetime', $casts['al']);
        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
    });
});
