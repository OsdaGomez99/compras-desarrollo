@extends('./layouts/app')

@section('titulo', 'Detalle de Modificación')

@isset($compra)
    @section('titulo-pagina', 'Detalle de Modificación N° ' . $compra->numero .' ('. $compra->tipo .')')
@endisset

@section('button')
    <a href="{{route('cotizaciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder"></a>
@endsection

//NO FUNCIONA
@section('contenido')
    @livewire('compras.cotizaciones.detalles-modificaciones-component', ['cotizacion' => $cotizacion ?? null])
@endsection
