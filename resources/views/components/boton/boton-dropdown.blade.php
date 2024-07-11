@switch($modo)
    @case('boton')
        <button type="button" class="dropdown-item" {{ $attributes }} >
            <span class="{{ $icon }}"></span>
            <span class="ml-1">{{ $text }}</span>
        </button>
        @break
    @case('link')
        <a class="dropdown-item cursor-pointer" {{ $attributes }} >
            <span class="{{ $icon }}"></span>
            <span class="ml-1">{{ $text }}</span>
        </a>
        @break
    @default

@endswitch

