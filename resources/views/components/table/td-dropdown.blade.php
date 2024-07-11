<td class="text-center">
    <div class="btn-group">
        @if ($estilo == 'bs')
            <button type="button" class="btn btn-icon btn-round btn-primary btn-border fas fa-bars"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
        @elseif ($estilo == 'tw')
            <button type="button" style="border: 1px solid;" class="h-10 w-10 rounded-full fas fa-bars {{ $colortxt }} {{ $colorbg }}"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
        @endif
        <div class="dropdown-menu">
            {{ $slot }}
        </div>
    </div>
</td>
