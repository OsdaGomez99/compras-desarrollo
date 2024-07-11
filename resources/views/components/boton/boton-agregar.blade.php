@if ($link)
<a title={{ $title }} href="{{ $link }}"
    {{ $attributes->merge(['class' => 'text-blue-500 btn bg-white btn-round fas fa-plus']) }}>
    <span class="font-sans text-base pl-1">Agregar</span>
</a>
@else
<button title={{ $title }}
    {{ $attributes->merge(['class' => 'text-blue-500 btn bg-white btn-round fas fa-plus']) }}>
    <span class="font-sans text-base pl-1">Agregar</span>
</button>
@endif
