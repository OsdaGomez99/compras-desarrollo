<thead class="bg-primary-gradient">
    <tr>
        @foreach ($encabezados as $index => $encabezado)
            <th class="text-white text-center font-bold tracking-wider" {{ isset($colspan[$index]) ? "colspan=$colspan[$index]" : "" }} {{ isset($anchos[$index]) ? "width=$anchos[$index]" : "" }} > {{ $encabezado }} </th>
        @endforeach
    </tr>
</thead>
