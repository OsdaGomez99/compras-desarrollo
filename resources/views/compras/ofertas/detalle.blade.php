@extends('./layouts/app')

@section('titulo', 'Detalle de Oferta de Proveedor')

@isset($oferta)
    @section('titulo-pagina', 'Detalle de Proveedor ' . $oferta->proveedor->nombre)
@endisset

@section('button')
    <a href="{{route('ofertas.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder"></a>
@endsection

@section('contenido')
    @livewire('compras.ofertas.detalles-ofertas-component', ['oferta' => $oferta ?? null])
@endsection
