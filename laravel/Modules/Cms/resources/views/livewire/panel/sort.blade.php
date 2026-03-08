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
    <a href="{{ $panel->url('index'); Back</a>
    <ul wire:sortable="updateTaskOrder">
        {{-- dddx($panel->rows($data
        @foreach ($rows->sortBy('pos'
            <li wire:sortable.item="{{ $row->id }}" wire:key="task-{{ $row->id }}">
                <h4 wire:sortable.handle>[{{ $row->pos }}] {!! $panel->optionLabel($row
                <button wire:click="removeTask({{ $row->id }})">Remove</button>
            </li>
        @endforeach
    </ul>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
@endpush
