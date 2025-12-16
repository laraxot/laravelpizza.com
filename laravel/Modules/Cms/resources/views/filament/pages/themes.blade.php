<?php

declare(strict_types=1);

?>
<x-filament::page>
    @if(count($data))
    <div class="grid grid-cols-3 gap-3">
        @foreach ($data as $theme)
        <div>
            <div>
                {{ $theme['info']['name'] }}
                <p class="text-sm text-gray-400">{{ $theme['info']['description'] }}</p>
            </div>
            {{-- <hr>
            <img src="{{url($theme['info']->image)}}" />
            <hr> --}}
            <div class="flex justify-start space-x-4">
                @if(config('xra.pub_theme') !== $theme['info']['name'])
                    <button wire:click="changePubTheme('{{ $theme['info']['name'] }}')"
                       class="inline-flex items-center justify-center font-medium tracking-tight transition rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 h-9 px-4 text-white shadow focus:ring-white">
                        {{__('Active')}}
                    </button>
                @else
                    <button
                       class="inline-flex items-center justify-center font-medium tracking-tight transition rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 h-9 px-4 text-white shadow focus:ring-white">
                        {{__('Preview')}}
                    </button>
                @endif
                {{-- <form method="POST" action="{{route('admin.themes.destroy', $theme['info']->aliases)}}">
                    @csrf
                    @method('POST')
                    <button type="submit" href="{{url('/')}}" target="_blank"
                       class="inline-flex items-center justify-center font-medium tracking-tight transition rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset bg-danger-600 hover:bg-danger-500 focus:bg-danger-700 focus:ring-offset-danger-700 h-9 px-4 text-white shadow focus:ring-white">
                        {{__('Delete')}}
                    </button>
                </form> --}}
            </div>
        </div>
        @endforeach

    </div>
    @else
        <div>
            <div class="flex justify-center">
                <x-heroicon-o-x-circle class="w-16 h-16 text-danger-500 text-center"/>
            </div>
            <p class="text-gray-500 text-center">
                {{__('Sorry No themes found please create new')}}
            </p>
        </div>
    @endif

</x-filament::page>
