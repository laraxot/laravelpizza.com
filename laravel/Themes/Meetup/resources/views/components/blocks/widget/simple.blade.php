<div class="widget-simple">
    @if(isset($to) && $to)
        <a href="{{ $to }}" 
           class="{{ $class ?? 'btn btn-primary' }}"
           @if(isset($external) && $external) target="_blank" @endif>
            @if(isset($icon) && $icon)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $label ?? 'Vai' }}
        </a>
    @else
        <button class="{{ $class ?? 'btn btn-primary' }}" disabled>
            @if(isset($icon) && $icon)
                <i class="{{ $icon }}"></i>
            @endif
            {{ $label ?? 'Vai' }}
        </button>
    @endif
</div>
