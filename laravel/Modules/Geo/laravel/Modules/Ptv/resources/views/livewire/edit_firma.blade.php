    @if ($stabi != '')
        <form class="form-inline">
            <input type="text" wire:model="nome_stabi" id="nome_stabi" class="form-control col-4"
                placeholder="nome_stabi" />
            <input type="text" wire:model="nome_diri" id="nome_diri" class="form-control col-4"
                placeholder="nome_diri" />
            <button type="submit" class="btn btn-primary" wire:click.prevent="update()">
                <i class="far fa-save"></i>
            </button>
        </form>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
</div>
