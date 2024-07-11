<button type="button" {{ $attributes->merge(['class' => "btn-round btn-danger btn-border border px-4 py-2"]) }} >
    {{ $slot }}
</button>
