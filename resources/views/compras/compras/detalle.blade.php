@extends('./layouts/app')

@section('titulo', 'Detalle de Compra')

@isset($compra)
    @section('titulo-pagina', 'Detalle de Compra N° ' . $compra->numero)
@endisset

@section('button')
    <a href="{{route('compras.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder"></a>
@endsection

@section('contenido')
    @livewire('compras.compras.detalles-compras-component', ['compra' => $compra ?? null])
@endsection
