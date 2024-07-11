@extends('./layouts/app')

@section('titulo', ' Nueva Solicitud')

@section('titulo-pagina', 'Nueva Solicitud')

@isset($id)
    @section('titulo', 'Edición de Solicitud')
    @section('titulo-pagina', 'Edición de Solicitud')
@else
    @section('titulo', 'Registro de Solicitud')
    @section('titulo-pagina', 'Registro de Solicitud')
@endisset

@section('button')
    <a href="{{route('modificaciones.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

@section('contenido')
    @livewire('compras.modificaciones.modificaciones-compra-form-component', ['id' => $id ?? null])
@endsection
