<?php

declare(strict_types=1);

?>
<div>
    @php
        if (!isset($prefix)) {
            $prefix = '';
        }
    @endphp
    <table class="table table-bordered table-striped table-hover table-sm">
        @foreach ($form_data as $k => $v)
            <tr>
                <td>{{ $k }}</td>
                <td> {{-- <input type="text" wire:model="form_data.{{ $k }}" /> --}}
                    @if (is_array($v))
                        @include('xot::livewire.manage_lang_module.edit',['form_data'=>$v,'prefix'=>$prefix.'.'.$k])
                    @else
                        <input type="text" wire:model="form_data{{ $prefix }}.{{ $k }}"
                            class="form-control" />
                    @endif
                </td>
            </tr>
        @endforeach
    </table>


</div>
