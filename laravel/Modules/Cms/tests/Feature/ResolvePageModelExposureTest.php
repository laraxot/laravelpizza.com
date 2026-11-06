<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

// Il test usa il TestCase del modulo: eredita il bootstrap applicativo root e
// mantiene un solo binding Pest per la directory Cms.
/*
 * DCP-283 (C-04): ResolvePageAction non deve piu' caricare modelli arbitrari dai due segmenti dell'URL.
 * Prima (misurato): /it/profile/<uuid> e /it/user/<uuid> rispondevano 200 per un utente reale (anche a un ospite) e 404 per
 * uno inesistente, e lo snapshot Livewire portava classe e chiave del modello. Ora solo blog/events e i contenitori elencati
 * in `cms.config.container0_models`, con scope del modello e policy `view`.
 */

/** Modello di prova su una tabella sqlite in memoria, con uno scope globale: nasconde le righe `visible = 0`. */
final class Dcp283Item extends Model
{
    public $timestamps = false;

    protected $connection = 'dcp283';

    protected $table = 'dcp283_items';

    protected $guarded = [];

    #[Override]
    protected static function booted(): void
    {
        self::addGlobalScope('dcp283-visible', static function (Builder $query): void {
            $query->where('visible', true);
        });
    }
}

final class Dcp283AllowViewPolicy
{
    public function view(?Authenticatable $user, Dcp283Item $model): bool
    {
        return true;
    }
}

final class Dcp283DenyViewPolicy
{
    public function view(?Authenticatable $user, Dcp283Item $model): bool
    {
        return false;
    }
}

/**
 * Crea la tabella di prova (sqlite in memoria, una per test) con una riga visibile (id 1) e una nascosta dallo scope (id 2).
 */
function dcp283Items(): void
{
    config(['database.connections.dcp283' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '']]);
    DB::purge('dcp283');
    Schema::connection('dcp283')->create('dcp283_items', static function (Blueprint $table): void {
        $table->increments('id');
        $table->boolean('visible');
    });
    Dcp283Item::query()->withoutGlobalScopes()->insert([['id' => 1, 'visible' => true], ['id' => 2, 'visible' => false]]);
}

/** Chiave di rotta (UUID) dell'utente, come stringa. */
function dcp283KeyOf(User $user): string
{
    $key = $user->getRouteKey();
    if (! is_string($key)) {
        throw new LogicException('La chiave di rotta dell\'utente di prova non e una stringa.');
    }

    return $key;
}

/** @return array{visible: User, hidden: User} */
function dcp283Users(): array
{
    return [
        'visible' => UserFactory::new()->createOne(['email' => 'visible-'.uniqid().'@example.test']),
        'hidden' => UserFactory::new()->createOne(['email' => 'hidden-'.uniqid().'@example.test']),
    ];
}

test('un ospite non distingue un utente reale da uno inesistente su /profile e /user', function (string $container): void {
    $users = dcp283Users();
    $realKey = dcp283KeyOf($users['visible']);

    $real = $this->get('/it/'.$container.'/'.$realKey);
    $missing = $this->get('/it/'.$container.'/'.(string) Str::uuid());

    Assert::assertSame(404, $real->getStatusCode(), 'un utente reale non deve produrre una pagina');
    Assert::assertSame($missing->getStatusCode(), $real->getStatusCode(), 'nessun oracolo di esistenza');
    Assert::assertStringNotContainsString('Models\\\\User', (string) $real->getContent(), 'il nome della classe non deve comparire nello snapshot');
})->with(['profile', 'user']);

test('nemmeno un utente loggato carica il profilo di un altro dall URL', function (): void {
    $users = dcp283Users();
    $this->actingAs($users['hidden']);

    $this->get('/it/profile/'.dcp283KeyOf($users['visible']))->assertNotFound();
    $this->get('/it/user/'.dcp283KeyOf($users['visible']))->assertNotFound();
});

test('un contenitore non elencato non carica nessun modello', function (): void {
    dcp283Items();
    Gate::policy(Dcp283Item::class, Dcp283AllowViewPolicy::class);

    $result = app(ResolvePageAction::class)->execute('dcp283', '1');

    Assert::assertNull($result->item);
    Assert::assertSame('cms', $result->renderMode);
});

test('il ramo profile e l euristica del singolare non esistono piu', function (): void {
    $users = dcp283Users();
    $key = dcp283KeyOf($users['visible']);

    foreach (['profile', 'user', 'users'] as $container) {
        Assert::assertNull(app(ResolvePageAction::class)->execute($container, $key)->item, $container);
    }
});

test('un contenitore elencato carica il modello solo se la policy view lo consente', function (): void {
    dcp283Items();
    config(['cms.config.container0_models' => ['dcp283' => Dcp283Item::class]]);
    Gate::policy(Dcp283Item::class, Dcp283AllowViewPolicy::class);

    $result = app(ResolvePageAction::class)->execute('dcp283', '1');

    Assert::assertInstanceOf(Dcp283Item::class, $result->item);
    Assert::assertSame('model', $result->renderMode);
    Assert::assertSame('dcp283.view', $result->pageSlug);
});

test('una policy che nega rende il modello indistinguibile da non trovato', function (): void {
    dcp283Items();
    config(['cms.config.container0_models' => ['dcp283' => Dcp283Item::class]]);
    Gate::policy(Dcp283Item::class, Dcp283DenyViewPolicy::class);

    Assert::assertNull(app(ResolvePageAction::class)->execute('dcp283', '1')->item);
});

test('senza policy il modello elencato non viene esposto', function (): void {
    dcp283Items();
    config(['cms.config.container0_models' => ['dcp283' => Dcp283Item::class]]);

    Assert::assertNull(app(ResolvePageAction::class)->execute('dcp283', '1')->item);
});

test('lo scope globale del modello vale: un record escluso non e raggiungibile', function (): void {
    dcp283Items();
    Gate::policy(Dcp283Item::class, Dcp283AllowViewPolicy::class);
    // alias retrocompatibile: stessa semantica della chiave del modulo
    config(['xra.container0_model_map' => ['dcp283' => Dcp283Item::class]]);

    Assert::assertNull(app(ResolvePageAction::class)->execute('dcp283', '2')->item, 'riga nascosta dallo scope');
    Assert::assertInstanceOf(Dcp283Item::class, app(ResolvePageAction::class)->execute('dcp283', '1')->item);
});

test('una voce di configurazione che non e un modello viene ignorata', function (): void {
    config(['cms.config.container0_models' => ['dcp283' => 'Illuminate\\Support\\Facades\\Artisan', 'dcp284' => 12]]);

    Assert::assertNull(app(ResolvePageAction::class)->execute('dcp283', '1')->item);
    Assert::assertNull(app(ResolvePageAction::class)->execute('dcp284', '1')->item);
});

test('blog ed events restano serviti dal finder dei soli contenuti pubblicati', function (): void {
    // Blog e' un modulo opzionale (ResolvePageAction usa il finder solo se Article e ThemeComposer esistono): la classe si risolve per nome.
    $article = app('Modules\\Blog\\Models\\Article');
    Assert::assertInstanceOf(Model::class, $article);
    $composer = new class($article)
    {
        public function __construct(private readonly Model $article) {}

        public function findPublishedPostBySlug(string $slug): ?Model
        {
            return $slug === 'post-pubblicato' ? $this->article : null;
        }

        public function findPublishedEventBySlug(string $slug): ?Model
        {
            return $slug === 'evento-pubblicato' ? $this->article : null;
        }
    };
    app()->instance('Modules\\Blog\\View\\Composers\\ThemeComposer', $composer);
    $action = app(ResolvePageAction::class);

    Assert::assertSame($article, $action->execute('blog', 'post-pubblicato')->item);
    Assert::assertSame('model', $action->execute('blog', 'post-pubblicato')->renderMode);
    Assert::assertSame($article, $action->execute('events', 'evento-pubblicato')->item);
    Assert::assertNull($action->execute('blog', 'evento-pubblicato')->item, 'un evento non si legge come post');
    Assert::assertNull($action->execute('events', 'post-pubblicato')->item, 'un post non si legge come evento');
    Assert::assertNull($action->execute('blog', 'inesistente')->item);
})->skip(
    ! class_exists('Modules\\Blog\\Models\\Article') || ! class_exists('Modules\\Blog\\View\\Composers\\ThemeComposer'),
    'Modulo Blog non installato: ResolvePageAction non usa il finder dei contenuti pubblicati.'
);
