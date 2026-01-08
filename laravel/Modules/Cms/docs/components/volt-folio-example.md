# Esempio Pratico Laravel Volt e Folio

## Struttura del Progetto

La struttura base del progetto segue l'organizzazione standard di Laravel con alcune personalizzazioni per il modulo CMS:

```plaintext
Modules/Cms/
├── Resources/
│   └── views/
│       ├── components/
│       │   └── volt/
│       └── pages/
│           ├── index.blade.php
│           ├── posts/
│           │   ├── [id].blade.php
│           │   └── create.blade.php
│           └── dashboard.blade.php
├── Models/
│   └── Post.php
└── Tests/
    └── Feature/
        └── PostTest.php
```

## Implementazione

### 1. Pagina Home con Lista Post

```php
<?php

// Resources/views/pages/index.blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Post;

state(['search' => '']);

$posts = computed(function () {
    return Post::query()
        ->when($this->search, fn($query) => 
            $query->where('title', 'like', "%{$this->search}%")
        )
        ->latest()
        ->get();
});
?>

<x-layouts.cms>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Post Recenti</h1>
                
                <x-cms::input-field
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cerca post..."
                    class="w-64"
                />
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($posts as $post)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                {{ $post->title }}
                            </h2>
                            
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit($post->content, 100) }}
                            </p>
                            
                            <x-cms::link-button 
                                href="{{ route('cms.posts.show', $post) }}"
                            >
                                Leggi di più
                            </x-cms::link-button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.cms>
```

### 2. Form Creazione Post

```php
<?php

// Resources/views/pages/posts/create.blade.php
use function Livewire\Volt\{state, rules};
use Modules\Cms\Models\Post;

state([
    'title' => '',
    'content' => '',
    'published' => false,
]);

rules([
    'title' => 'required|min:3|max:255',
    'content' => 'required|min:10',
]);

$save = function () {
    $this->validate();
    
    $post = Post::create([
        'title' => $this->title,
        'content' => $this->content,
        'published' => $this->published,
        'user_id' => auth()->id(),
    ]);
    
    session()->flash('success', 'Post creato con successo!');
    
    return redirect()->route('cms.posts.show', $post);
};
?>

<x-layouts.cms>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-semibold mb-6">Nuovo Post</h1>

                <form wire:submit="save" class="space-y-6">
                    <x-cms::input-field
                        wire:model="title"
                        label="Titolo"
                        :error="$errors->first('title')"
                    />

                    <x-cms::textarea-field
                        wire:model="content"
                        label="Contenuto"
                        rows="6"
                        :error="$errors->first('content')"
                    />

                    <x-cms::checkbox-field
                        wire:model="published"
                        label="Pubblica immediatamente"
                    />

                    <div class="flex justify-end">
                        <x-cms::button type="submit">
                            Salva Post
                        </x-cms::button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.cms>
```

### 3. Visualizzazione Post Singolo

```php
<?php

// Resources/views/pages/posts/[id].blade.php
use function Livewire\Volt\{state, computed};
use Modules\Cms\Models\Post;

state(['post' => fn () => Post::findOrFail($id)]);

$canEdit = computed(function () {
    return auth()->user()->can('update', $this->post);
});

$delete = function () {
    if (! auth()->user()->can('delete', $this->post)) {
        return;
    }
    
    $this->post->delete();
    
    session()->flash('success', 'Post eliminato con successo!');
    
    return redirect()->route('cms.posts.index');
};
?>

<x-layouts.cms>
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-3xl font-semibold">
                        {{ $post->title }}
                    </h1>

                    @if($canEdit)
                        <div class="flex gap-2">
                            <x-cms::link-button
                                href="{{ route('cms.posts.edit', $post) }}"
                                variant="secondary"
                            >
                                Modifica
                            </x-cms::link-button>

                            <x-cms::button
                                wire:click="delete"
                                wire:confirm="Sei sicuro di voler eliminare questo post?"
                                variant="danger"
                            >
                                Elimina
                            </x-cms::button>
                        </div>
                    @endif
                </div>

                <div class="prose max-w-none">
                    {{ $post->content }}
                </div>

                <div class="mt-6 text-sm text-gray-500">
                    Pubblicato il {{ $post->created_at->format('d/m/Y') }}
                    da {{ $post->user->name }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.cms>
```

## Testing

### Test dei Post

```php
namespace Modules\Cms\Tests\Feature;

use Tests\TestCase;
use Livewire\Volt\Volt;
use Modules\Cms\Models\{Post, User};

class PostTest extends TestCase
{
    /** @test */
    public function it_can_display_posts_list()
    {
        $posts = Post::factory()->count(3)->create();

        Volt::test('index')
            ->assertSee($posts[0]->title)
            ->assertSee($posts[1]->title)
            ->assertSee($posts[2]->title);
    }

    /** @test */
    public function it_can_filter_posts()
    {
        $matchingPost = Post::factory()->create(['title' => 'Match This']);
        $nonMatchingPost = Post::factory()->create(['title' => 'Different']);

        Volt::test('index')
            ->set('search', 'Match')
            ->assertSee($matchingPost->title)
            ->assertDontSee($nonMatchingPost->title);
    }

    /** @test */
    public function it_can_create_post()
    {
        $user = User::factory()->create();

        Volt::test('posts.create')
            ->set('title', 'New Post')
            ->set('content', 'Post content here')
            ->set('published', true)
            ->call('save')
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            'content' => 'Post content here',
            'published' => true,
            'user_id' => $user->id,
        ]);
    }
}
```

## Ottimizzazioni

### 1. Cache dei Post

```php
$posts = computed(function () {
    $cacheKey = 'posts.list.' . $this->search;
    
    return cache()->remember($cacheKey, now()->addMinutes(5), function () {
        return Post::query()
            ->when($this->search, fn($query) => 
                $query->where('title', 'like', "%{$this->search}%")
            )
            ->latest()
            ->get();
    });
});
```

### 2. Lazy Loading delle Immagini

```php
<img 
    src="{{ $post->thumbnail_url }}"
    loading="lazy"
    class="w-full h-48 object-cover"
    alt="{{ $post->title }}"
/>
```

### 3. Debounce sulla Ricerca

```php
<x-cms::input-field
    wire:model.live.debounce.300ms="search"
    placeholder="Cerca post..."
/>
```

## Best Practices

1. **Organizzazione del Codice**
   - Utilizzare computed properties per query complesse
   - Separare la logica in metodi dedicati
   - Mantenere i componenti piccoli e focalizzati

2. **Performance**
   - Implementare caching dove appropriato
   - Utilizzare lazy loading per immagini e componenti pesanti
   - Ottimizzare le query del database

3. **Testing**
   - Testare tutti i componenti Volt
   - Verificare la funzionalità di filtri e ricerche
   - Testare le autorizzazioni e la sicurezza

## Risorse Utili

- [Esempio Completo su GitHub](https://github.com/jasonlbeggs/laravel-news-volt-folio-example)
- [Documentazione Laravel Volt](https://livewire.laravel.com/docs/volt)
- [Documentazione Laravel Folio](https://laravel.com/docs/folio) 
