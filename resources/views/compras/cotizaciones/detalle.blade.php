@extends('./layouts/app')

@section('titulo', 'Detalle de Cotización')

@isset($cotizacion)
    @section('titulo-pagina', 'Detalle de Cotización N° ' . $cotizacion->numero .' ('. $cotizacion->tipo .')')
@endisset

@section('button')
    <a href="{{route('cotizaciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder"></a>
@endsection

@section('contenido')
    @livewire('compras.cotizaciones.detalles-cotizaciones-component', ['cotizacion' => $cotizacion ?? null])
@endsection
