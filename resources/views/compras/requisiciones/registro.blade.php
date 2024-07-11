@extends('./layouts/app')

@isset($id)
    @section('titulo', 'Edición de Requisición ('. $tipo .')')
    @section('titulo-pagina', 'Edición de Requisición ('. $tipo .')')
@else
    @section('titulo', 'Registro de Requisición ('. $tipo .')')
    @section('titulo-pagina', 'Registro de Requisición ('. $tipo .')')
@endisset

@section('button')
    <a href="{{route('requisiciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.requisiciones.requisiciones-form-component', ['id' => $id ?? null, 'tipo' => $tipo ?? null])
@endsection
