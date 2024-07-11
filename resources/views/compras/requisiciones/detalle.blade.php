@extends('./layouts/app')

@section('titulo', 'Detalle de Requisición')

@isset($requisicion)
    @section('titulo-pagina', 'Detalle de Requisición N° ' . $requisicion->numero .' ('. $requisicion->tipo .')')
@endisset

@section('button')
    <a href="{{route('requisiciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder"></a>
@endsection

@section('contenido')
    @livewire('compras.requisiciones.detalles-requisiciones-component', ['requisicion' => $requisicion ?? null])
@endsection
