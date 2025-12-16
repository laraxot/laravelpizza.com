<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Models\Activity;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\User\Models\User;
use Tests\TestCase;

class ListLogActivitiesActionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test che l'Action possa essere istanziata correttamente.
     */
    public function test_can_instantiate_action(): void
    {
        $action = ListLogActivitiesAction::make();

        $this->assertInstanceOf(ListLogActivitiesAction::class, $action);
        $this->assertEquals('list_log_activities', $action::getDefaultName());
    }

    /**
     * Test che l'Action abbia le configurazioni corrette.
     */
    public function test_action_has_correct_configuration(): void
    {
        $action = ListLogActivitiesAction::make();

        // Verifica che l'action sia configurata correttamente
        $this->assertEquals('heroicon-o-clock', $action->getIcon());
        $this->assertEquals('gray', $action->getColor());
    }

    /**
     * Test che l'Action possa generare l'URL corretto per una risorsa.
     */
    public function test_action_generates_correct_url(): void
    {
        // Crea un utente per il test
        $user = User::factory()->create();

        // Crea un record di test
        $record = IndennitaResponsabilita::factory()->create([
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $action = ListLogActivitiesAction::make();

        // Simula un Livewire component per testare l'URL generation
        $mockLivewire = new class {
            public function getResource() {
                return \Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource::class;
            }
        };

        // Test che l'URL venga generato correttamente
        $url = $action->getUrl($mockLivewire, $record);

        $this->assertStringContains('log-activity', $url);
        $this->assertStringContains((string)$record->getKey(), $url);
    }

    /**
     * Test che l'Action possa trovare la classe Resource corretta.
     */
    public function test_action_can_find_resource_class(): void
    {
        $action = ListLogActivitiesAction::make();

        // Test con un modello esistente
        $modelClass = IndennitaResponsabilita::class;
        $resourceClass = $action->findResourceClass($modelClass);

        $this->assertNotNull($resourceClass);
        $this->assertStringContains('IndennitaResponsabilitaResource', $resourceClass);
    }

    /**
     * Test che l'Action possa estrarre etichette dai campi.
     */
    public function test_action_can_extract_field_labels(): void
    {
        $action = ListLogActivitiesAction::make();

        $record = IndennitaResponsabilita::factory()->create();

        // Test estrazione etichetta per un campo esistente
        $label = $action->getFieldLabel('ente');

        // Dovrebbe restituire qualcosa di sensato
        $this->assertIsString($label);
        $this->assertNotEmpty($label);
    }

    /**
     * Test che l'Action possa gestire casi senza Resource.
     */
    public function test_action_handles_missing_resource(): void
    {
        $action = ListLogActivitiesAction::make();

        // Test con un modello che non ha Resource
        $modelClass = Activity::class;
        $resourceClass = $action->findResourceClass($modelClass);

        // Dovrebbe restituire null per modelli senza Resource
        $this->assertNull($resourceClass);
    }

    /**
     * Test che l'Action possa gestire record senza attività.
     */
    public function test_action_handles_record_without_activities(): void
    {
        $record = IndennitaResponsabilita::factory()->create();

        $action = ListLogActivitiesAction::make();

        // Il contenuto del modal dovrebbe contenere il messaggio di nessuna attività
        $content = $action->getActivitiesModalContent($record);

        $this->assertStringContains('Nessuna modifica registrata', $content);
    }

    /**
     * Test che l'Action possa generare contenuto per record con attività.
     */
    public function test_action_generates_content_for_record_with_activities(): void
    {
        $user = User::factory()->create();
        $record = IndennitaResponsabilita::factory()->create([
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Crea un'attività di test
        activity()
            ->performedOn($record)
            ->causedBy($user)
            ->withProperties(['old' => ['ente' => 80], 'attributes' => ['ente' => 90]])
            ->log('updated');

        $action = ListLogActivitiesAction::make();
        $content = $action->getActivitiesModalContent($record);

        // Dovrebbe contenere informazioni sull'attività
        $this->assertStringContains($user->name, $content);
        $this->assertStringContains('Aggiornato', $content);
    }

    /**
     * Test che l'Action possa navigare correttamente.
     */
    public function test_action_can_navigate(): void
    {
        $user = User::factory()->create();
        $record = IndennitaResponsabilita::factory()->create([
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $action = ListLogActivitiesAction::make();

        // Test che possa determinare la classe della pagina
        $pageClass = $action->getActivitiesPageClass($record);

        $this->assertNotNull($pageClass);
        $this->assertTrue(class_exists($pageClass));
    }

    /**
     * Test che l'Action possa estrarre classe da file PHP.
     */
    public function test_action_can_extract_class_from_file(): void
    {
        $action = ListLogActivitiesAction::make();

        // Test estrazione classe da file esistente
        $resourceFile = base_path('laravel/Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource.php');
        $extractedClass = $action->getClassFromFile($resourceFile);

        $this->assertNotNull($extractedClass);
        $this->assertStringContains('IndennitaResponsabilitaResource', $extractedClass);
    }
}

