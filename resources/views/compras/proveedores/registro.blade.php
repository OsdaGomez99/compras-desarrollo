@extends('./layouts/app')

@isset($id)
    @section('titulo', 'Edición de Proveedor')
    @section('titulo-pagina', 'Edición de Proveedor')
@else
    @section('titulo', 'Registro de Proveedor')
    @section('titulo-pagina', 'Registro de Proveedor')
@endisset

@section('descripcion-pagina', '')

@section('button')
    <a href="{{route('proveedores.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.proveedores.proveedores-form-component', ['id' => $id ?? null])
@endsection
