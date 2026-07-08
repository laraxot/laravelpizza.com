<?php

declare(strict_types=1);

namespace Modules\Pdnd\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SslCertificateTest extends TestCase
{
    /** @test */
    public function it_can_connect_to_https_endpoint_and_verify_certificate(): void
    {
        $response = Http::timeout(10)->get('https://auth.uat.interop.pagopa.it');

        $this->assertTrue($response->successful(), 'La richiesta HTTPS non ha avuto successo.');

        // Facoltativo: Verifica che il contenuto contenga qualcosa di atteso
        $this->assertStringContainsString('Pagopa', $response->body(), 'Il contenuto della risposta non è quello atteso.');
    }
}
