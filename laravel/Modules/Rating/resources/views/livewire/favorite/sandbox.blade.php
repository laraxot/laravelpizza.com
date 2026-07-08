<div>
    @if ($fav)
        <a class="btn btn-sm btn-soft-primary text-grape rounded-pill mb-3" wire:click="update()"><i
                class="uil uil-star"></i>&nbsp; Rimuovi dai preferiti
        </a>
    @else
        <a class="btn btn-sm btn-primary text-white rounded-pill mb-3" wire:click="update()"><i
                class="uil uil-star"></i>&nbsp; Aggiungi ai preferiti
        </a>
    @endif
</div>
