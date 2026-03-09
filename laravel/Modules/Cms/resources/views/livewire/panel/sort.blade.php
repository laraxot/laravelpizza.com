<?php

declare(strict_types=1);

?>
<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <a href="{{ $this->panel->url('index') }}" class="btn btn-info">&laquo; Back</a>
    <ul wire:sortable="updateTaskOrder">
        {{-- dddx($this->panel->rows($data)->get()) --}}
        @foreach ($this->rows->sortBy('pos') as $row)
            <li wire:sortable.item="{{ $row->id }}" wire:key="task-{{ $row->id }}">
                <h4 wire:sortable.handle>[{{ $row->pos }}] {!! $this->panel->optionLabel($row) !!}</h4>
                <button wire:click="removeTask({{ $row->id }})">Remove</button>
            </li>
        @endforeach
    </ul>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush
