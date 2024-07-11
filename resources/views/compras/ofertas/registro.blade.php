@extends('./layouts/app')

@isset($id)
    @section('titulo', 'Edición Oferta de Proveedor')
    @section('titulo-pagina', 'Edición Oferta de Proveedor')
@else
    @section('titulo', 'Registro de Oferta de Proveedor')
    @section('titulo-pagina', 'Registro de Oferta de Proveedor')
@endisset

@section('button')
    <a href="{{route('ofertas.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.ofertas.ofertas-form-component', ['id' => $id ?? null, 'tipo' => $tipo ?? null])
@endsection
