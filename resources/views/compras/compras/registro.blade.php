@extends('./layouts/app')

@isset($req)
    @section('titulo', 'Edición de Compra ('. $tipo .')')
    @section('titulo-pagina', 'Edición de Compra ('. $tipo .')')
@else
    @section('titulo', 'Registro de Compra ('. $tipo .')')
    @section('titulo-pagina', 'Registro de Compra ('. $tipo .')')
@endisset

@section('descripcion-pagina', '')

@section('button')
<a href="{{route('compras.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.compras.compras-form-component', ['id' => $id ?? null, 'tipo' => $tipo ?? null])
@endsection
