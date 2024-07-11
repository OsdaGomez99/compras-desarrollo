@extends('./layouts/app')

@section('titulo', 'Modificación/Anulación de Compras')

@section('titulo-pagina', 'Modificación/Anulación de Compras')

@section('buscar')
    @livewire('busqueda-component', ['modulo' => 'modif'])
@endsection

@section('button')
<div>
    <x-boton.boton-agregar link="{{route('modificaciones.create')}}" title="Agregar solicitud" />
</div>
    <x-boton.boton-retroceder />
@endsection

@section('button')
    <x-boton.boton-retroceder />
@endsection

@section('contenido')
    @livewire('compras.modificaciones.modificaciones-compra-component')
@endsection


