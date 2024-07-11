@extends('./layouts/app')

@section('titulo', 'Nueva Evaluación de Proveedor')

@section('titulo-pagina', 'Nueva Evaluación de Proveedor')

@section('contenido')

@section('button')
<a href="{{route('evaluacionesprov.index')}}" class="inline ml-2 btn bg-white btn-round btn-round flaticon-back" title= "Retroceder">
    </a>
@endsection

//NO FUNCIONA
@section('contenido')
    @livewire('compras.modificaciones.evaluaciones-form-component', ['id' => $id ?? null, 'tipo' => $tipo ?? null])
@endsection
